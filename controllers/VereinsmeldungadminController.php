<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\filters\MyAccessControl;
use yii\filters\VerbFilter;
use app\models\Verein;
use app\models\user\User;
use app\models\user\Right;
use app\models\Vereinsmeldung\Season;
use app\models\vereinsmeldung\Vereinsmeldung;
use app\models\vereinsmeldung\vereinskontakte\VereinsmeldungKontakte;
use yii\web\ServerErrorHttpException;

class VereinsmeldungadminController extends Controller
{
    
    public function behaviors()
    {
        return [
            'access' => [
                'class' => MyAccessControl::class,
                'rules' => [
                    'index' => [ // if action is not set, access will be forbidden
                        'neededRight'    => Right::ID_RIGHT_VEREINSMELDUNG_ADMIN,
                        'allowedMethods' => [] // or [] for all
                    ],
                    'create-season' => [ // if action is not set, access will be forbidden
                        'neededRight'    => Right::ID_RIGHT_VEREINSMELDUNG_ADMIN,
                        'allowedMethods' => [] // or [] for all
                    ],
                    'edit-season' => [ // if action is not set, access will be forbidden
                        'neededRight'    => Right::ID_RIGHT_VEREINSMELDUNG_ADMIN,
                        'allowedMethods' => [] // or [] for all
                    ],
                    'delete-season' => [ // if action is not set, access will be forbidden
                        'neededRight'    => Right::ID_RIGHT_VEREINSMELDUNG_ADMIN,
                        'allowedMethods' => [] // or [] for all
                    ],
                    // all other actions are allowed
                ],
            ],
        ];
    }
    

    /**
     * Übersicht
     */
    public function actionIndex()
    {
        $seasons  = Season::find()->orderBy('id desc')->all();
        
        return $this->render('index',[
            'seasons' => $seasons
        ]);
    }

    /**
     * Übersicht
     * @param int $p season_id
     */
    public function actionCreateSeason()
    {
        $model  = new \app\models\forms\SeasonEditForm();

        $transaction = Yii::$app->db->beginTransaction();
        try {
            if($model->load(Yii::$app->request->post()) && $model->validate() ){
                $season = new Season();
                $season = $model->mapToItem($season);
                if($season->create() && $model->saveModules($season)){
                    $transaction->commit();
                    $this->redirect (['vereinsmeldungadmin/index']);
                }
                else {
                    Yii::debug(json_encode($season->getErrors()));
                    $transaction->rollBack();            
                }
            }
        } catch (\Exception $e) {
            Yii::debug($e->getMessage(), __METHOD__);
            $transaction->rollBack();
        }        
            
        $allModules  = \app\models\vereinsmeldung\Vereinsmeldemodul::find()->all();
        return $this->render('createSeason',[
            'model'         => $model,
            'allModules'    => $allModules,
        ]);
    }
    
    /**
     * Übersicht
     * @param int $p season_id
     */
    public function actionEditSeason($p)
    {
        $season = Season::find()->where(['id'=>$p])->one();
                
        if($season){
            $model = new \app\models\forms\SeasonEditForm();
            $model->mapFromItem($season);
            
            if($model->load(Yii::$app->request->post()) && $model->validate() ){
                $season = $model->mapToItem($season);
                if($season->save() && $model->saveModules($season)){
                    $this->redirect (['vereinsmeldungadmin/index']);
                }
                else {
                    Yii::debug(json_encode($season->getErrors()));
                    $transaction->rollBack();            
                }
            }
            //ausgewählt vorbereiten
            $checked_ids = [];
            foreach($season->vereinsmeldemodule as $item){
                $checked_ids[] = $item->id;
            }
            $model->checked_ids = $checked_ids;
            
            $allModules  = \app\models\vereinsmeldung\Vereinsmeldemodul::find()->all();
            return $this->render('editSeason',[
                'model'         => $model,
                'season'        => $season,
                'checked_ids'   => $model->checked_ids,
                'allModules'    => $allModules,
            ]);

        }
        Yii::error("Season EDIT: Season not found (ID ".$p.")", __METHOD__);
        throw new NotFoundHttpException("Season not found");

    }
    
    
    /**
     * Löschen
     * @param int $p season_id
     */
    public function actionDeleteSeason($p)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $season = Season::find()->where(['id'=>$p])->one();
            if($season && $season->deleteSeason()){
                $this->redirect (['vereinsmeldungadmin/index']);
                $transaction->commit();
            }
            else {
                Yii::debug(json_encode($season->getErrors()), __METHOD__);
                $transaction->rollBack();
            }
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::error($e->getMessage(),__METHOD__);
            throw new ServerErrorHttpException('Ups...es ist ein Fehler aufgetreten.');
        }        
        
        
    }    
}
