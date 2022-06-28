<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\filters\MyAccessControl;
use yii\filters\VerbFilter;
use app\models\Verein;
use app\models\user\Right;
use app\models\vereinsmeldung\Season;
use app\models\vereinsmeldung\vereinskontakte\Vereinsmeldung;
use app\models\vereinsmeldung\vereinskontakte\VereinsmeldungKontakte;
use app\models\vereinsmeldung\vereinskontakte\Vereinsrolle;
use app\models\vereinsmeldung\vereinskontakte\Vereinskontakt;
use app\models\vereinsmeldung\vereinskontakte\Person;
use yii\web\ServerErrorHttpException;
use yii\web\NotFoundHttpException;

class VereinskontakteController extends Controller
{
    
    public function behaviors()
    {
        return [
            'access' => [
                'class' => MyAccessControl::class,
                'rules' => [
                    'index' => [ // if action is not set, access will be forbidden
                        'neededRight'    => Right::ID_RIGHT_VEREINSKONTAKTE,
                        'allowedMethods' => [] // or [] for all
                    ],
                    'uebersicht' => [ // if action is not set, access will be forbidden
                        'neededRight'    => Right::ID_RIGHT_VEREINSKONTAKTE_EINSEHEN,
                        'allowedMethods' => [] // or [] for all
                    ],
                    // all other actions are allowed
                ],
            ],
        ];
    }
    

    /**
     * Pflege Vereinskontakte als Verein außerhalb der Vereinsmeldung
     */
    public function actionIndex()
    {
        $seasons  = Season::find()->orderBy('id desc')->all();
        
        return $this->render('index',[
            'seasons' => $seasons
        ]);
    }


    /**
     * Admin: Übersicht Vereinskontakte alle Vereine
     * @param int $p Id der Saison, zu der die Daten geladen werden sollen
     */
    public function actionUebersicht($p = false)
    {
        try {
            //saison laden
            $season = Season::getSeason($p); //aktive oder gewuenschte Saison
            if(!$season) throw new NotFoundHttpException('Saison nicht gefunden');
            
            //Vereinsmeldung der Saison laden
            $vereinsmeldungen = $season->getVereinsmeldungen()->all();

            return $this->render('uebersicht',[
                'season'           => $season,
                'vereinsmeldungen' => $vereinsmeldungen,
            ]);
        }
        catch(\yii\base\Exception $e) {
            Yii::error($e->getMessage(),__METHOD__);
            throw new ServerErrorHttpException($e->getMessage());
        }
    }
    
    
    
}
