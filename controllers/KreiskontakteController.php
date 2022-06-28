<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\filters\MyAccessControl;
use yii\filters\VerbFilter;
use app\models\user\Right;
use app\models\vereinsmeldung\vereinskontakte\Funktionsgruppe;
use app\models\kreiskontakte\Kreiskontakt;
use app\models\kreiskontakte\Kreisperson;
use app\models\vereinsmeldung\vereinskontakte\Vereinsrolle;
use yii\web\ServerErrorHttpException;
use yii\web\NotFoundHttpException;
use yii\base\Exception;

class KreiskontakteController extends Controller
{
    
    public function behaviors()
    {
        return [
            'access' => [
                'class' => MyAccessControl::class,
                'rules' => [
                    'index' => [ // if action is not set, access will be forbidden
                        'neededRight'    => Right::ID_RIGHT_KREISKONTAKTE_PFLEGEN,
                        'allowedMethods' => [] // or [] for all
                    ],
                    'add-person' => [ // if action is not set, access will be forbidden
                        'neededRight'    => Right::ID_RIGHT_KREISKONTAKTE_PFLEGEN,
                        'allowedMethods' => [] // or [] for all
                    ],
                    'edit-person' => [ // if action is not set, access will be forbidden
                        'neededRight'    => Right::ID_RIGHT_KREISKONTAKTE_PFLEGEN,
                        'allowedMethods' => [] // or [] for all
                    ],
                    'delete-person' => [ // if action is not set, access will be forbidden
                        'neededRight'    => Right::ID_RIGHT_KREISKONTAKTE_PFLEGEN,
                        'allowedMethods' => [] // or [] for all
                    ],
                    'ausschusszuordnung' => [ // if action is not set, access will be forbidden
                        'neededRight'    => Right::ID_RIGHT_KREISKONTAKTE_PFLEGEN,
                        'allowedMethods' => [] // or [] for all
                    ],
                    
                    // all other actions are allowed
                ],
            ],
        ];
    }
    

    /**
     * Pflege Kreiskontakte
     */
    public function actionIndex()
    {
        try {
            $funktionsgruppen   = Funktionsgruppe::getKreisgruppen();
            $persons            = Kreisperson::find()->all();

            return $this->render('index',[
                'funktionsgruppen'  => $funktionsgruppen,
                'persons'           => $persons,
            ]);
        }
        catch(\yii\base\Exception $e) {
            Yii::error($e->getMessage(),__METHOD__);
            throw new ServerErrorHttpException($e->getMessage());
        }
    }

    /**
     * Kreiskontakte / Add Person
     * @param int $p Funktionsgruppe/Ausschuss ID
     */
    public function actionAddPerson($p)
    {
        try {
            $vereinsrollen          = Vereinsrolle::getVereinsrollen([Funktionsgruppe::$KREISVORSTAND_ID, Funktionsgruppe::$KREISJUGENDAUSSCHUSS_ID, Funktionsgruppe::$KREISKASSENPREUFER_ID])->select(['name'])->indexBy('id')->column();
            $user   = Yii::$app->user->identity;

            $model = new \app\models\forms\PersonEditForm();
            if($model->load(Yii::$app->request->post()) && $model->validate() ){
                $person = new Kreisperson();
                $person = $model->mapToPerson($person);
                if($person->create() && $model->saveKreisrollen($person)){
                    $this->redirect (['kreiskontakte/index']);
                }
                else {
                    Yii::debug(json_encode($person->getErrors()));
                }
            }

            return $this->render('addPerson',[
                'vereinsrollen'             => $vereinsrollen,
                'model'                     => $model,
            ]);

        }
        catch(\yii\base\Exception $e) {
            Yii::error($e->getMessage(),__METHOD__);
            throw new ServerErrorHttpException('Ups...ein Fehler. Die Person kann nicht angelegt werden.');
        }
        
    }

    /**
     * Kreiskontakte / Edit Person
     * @param int $p Person Id
     */
    public function actionEditPerson($p)
    {
        try {
            $person             = Kreisperson::find()->where(['id'=>$p])->one();
            if($person){
                $vereinsrollen          = Vereinsrolle::getVereinsrollen([Funktionsgruppe::$KREISVORSTAND_ID, Funktionsgruppe::$KREISJUGENDAUSSCHUSS_ID, Funktionsgruppe::$KREISKASSENPREUFER_ID])->select(['name'])->indexBy('id')->column();
                $user                   = Yii::$app->user->identity;

                $model = new \app\models\forms\PersonEditForm();
                $model->mapFromKreisperson($person);
                if($model->load(Yii::$app->request->post()) && $model->validate() ){
                    $person = $model->mapToPerson($person);
                    if($person->save() && $model->saveKreisrollen($person)){
                        $this->redirect (['kreiskontakte/index']);
                    }
                    else {
                        Yii::debug(json_encode($person->getErrors()));
                    }
                }

                return $this->render('editPerson',[
                    'vereinsrollen'             => $vereinsrollen,
                    'model'                     => $model,
                    'person'                    => $person,
                ]);
            }
            throw new Exception('Upps...Person wurde nicht gefunden.');
        }
        catch(\yii\base\Exception $e) {
            Yii::error($e->getMessage(),__METHOD__);
            throw new ServerErrorHttpException("Upps...ein Fehler. Die Person kann nicht bearbeitet werden.");
        }
        
    }
    
    /**
     * Löschen einer Person
     * @param int $p Person Id
     */
    public function actionDeletePerson($p)
    {
        try {
            $person         = Kreisperson::find()->where(['id'=>$p])->one();
            if($person->delete()){
                $this->redirect (['kreiskontakte/index']);
            }
        }
        catch(\yii\base\Exception $e) {
            Yii::error($e->getMessage(),__METHOD__);
            throw new ServerErrorHttpException("Upps...ein Fehler. Die Person kann nicht gelöscht werden.");
        }
    }    

    /**
     * Pflege Kreisausschuesse
     */
    public function actionAusschusszuordnung()
    {
        try {
            $funktionsgruppen   = Funktionsgruppe::getKreisgruppen();
            $vereinsrollen      = Vereinsrolle::getVereinsrollen([Funktionsgruppe::$KREISVORSTAND_ID, Funktionsgruppe::$KREISJUGENDAUSSCHUSS_ID, Funktionsgruppe::$KREISKASSENPREUFER_ID])->all();

            return $this->render('ausschusszuordnung',[
                'funktionsgruppen'  => $funktionsgruppen,
                'vereinsrollen'     => $vereinsrollen,
            ]);
        }
        catch(\yii\base\Exception $e) {
            Yii::error($e->getMessage(),__METHOD__);
            throw new ServerErrorHttpException($e->getMessage());
        }
    }

    /**
     * Pflege Kreisausschuesse - rolle editieren
     * @param int $p ID der Vereinsrolle
     */
    public function actionAusschusszuordnungEditRole($p)
    {
        try {
            $vereinsrolle               = Vereinsrolle::find()->where(['id'=>$p])->one();
            $funktionsgruppen           = Funktionsgruppe::find()->where('id != 1')->select(['name'])->indexBy('id')->column();//Funktionsgruppe::getKreisgruppen();
            if($vereinsrolle){
                $zugeordneteAusschuesse = $vereinsrolle->getMitgliedInKreisausschuessen()->select(['name'])->indexBy('id')->column();
                $model = new \app\models\forms\AusschussRoleEditForm();
                $model->mapFromVereinsrolle($vereinsrolle);
                if($model->load(Yii::$app->request->post()) && $model->validate() ){
                    if($model->saveFunktionsgruppen($vereinsrolle)){
                        $this->redirect (['kreiskontakte/ausschusszuordnung']);
                    }
                    else {
                        Yii::debug(json_encode($person->getErrors()));
                    }
                }

                return $this->render('ausschusszuordnung_edit_role',[
                    'zugeordneteAusschuesse'    => $zugeordneteAusschuesse,
                    'funktionsgruppen'          => $funktionsgruppen,
                    'model'                     => $model,
                    'vereinsrolle'              => $vereinsrolle,
                ]);
            }
            throw new Exception('Upps...Rolle wurde nicht gefunden.');
        }
        catch(\yii\base\Exception $e) {
            Yii::error($e->getMessage().$e->getPrevious(),__METHOD__);
            throw new ServerErrorHttpException("Upps...ein Fehler. Die Rolle kann nicht bearbeitet werden.");
        }
    }


    
}
