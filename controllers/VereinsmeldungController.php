<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\filters\MyAccessControl;
use yii\filters\VerbFilter;
use app\models\Verein;
use app\models\user\User;
use app\models\user\Right;
use app\models\vereinsmeldung\Season;
use app\models\vereinsmeldung\Vereinsmeldung;
use app\models\vereinsmeldung\vereinskontakte\VereinsmeldungKontakte;
use app\models\vereinsmeldung\vereinskontakte\Person;
use app\models\vereinsmeldung\vereinskontakte\Vereinsrolle;
use app\models\vereinsmeldung\teams\VereinsmeldungTeams;
use app\models\vereinsmeldung\confirmclicktt\VereinsmeldungClickTT;
use app\models\vereinsmeldung\confirmpokal\VereinsmeldungPokal;
use yii\web\ServerErrorHttpException;
use yii\base\Exception;
use app\models\vereinsmeldung\teams\Altersbereich;
use app\models\vereinsmeldung\teams\Altersklasse;
use app\models\vereinsmeldung\teams\Liga;
use app\models\vereinsmeldung\teams\Ligazusammenstellung;
use app\models\vereinsmeldung\teams\Team;

class VereinsmeldungController extends Controller
{
    
    public function behaviors()
    {
        return [
            'access' => [
                'class' => MyAccessControl::class,
                'rules' => [
                    'index' => [ // if action is not set, access will be forbidden
                        'neededRight'    => Right::ID_RIGHT_VEREINSMELDUNG,
                        'allowedMethods' => [] // or [] for all
                    ],
                    'vereinskontakte' => [ // if action is not set, access will be forbidden
                        'neededRight'    => Right::ID_RIGHT_VEREINSMELDUNG,
                        'allowedMethods' => [] // or [] for all
                    ],
                    'add-person' => [ // if action is not set, access will be forbidden
                        'neededRight'    => Right::ID_RIGHT_VEREINSMELDUNG,
                        'allowedMethods' => [] // or [] for all
                    ],
                    'add-team' => [ // if action is not set, access will be forbidden
                        'neededRight'    => Right::ID_RIGHT_VEREINSMELDUNG,
                        'allowedMethods' => [] // or [] for all
                    ],
                    'edit-person' => [ // if action is not set, access will be forbidden
                        'neededRight'    => Right::ID_RIGHT_VEREINSMELDUNG,
                        'allowedMethods' => [] // or [] for all
                    ],
                    'delete-person' => [ // if action is not set, access will be forbidden
                        'neededRight'    => Right::ID_RIGHT_VEREINSMELDUNG,
                        'allowedMethods' => [] // or [] for all
                    ],
                    'teams' => [ // if action is not set, access will be forbidden
                        'neededRight'    => Right::ID_RIGHT_VEREINSMELDUNG,
                        'allowedMethods' => [] // or [] for all
                    ],
                    'add-team' => [ // if action is not set, access will be forbidden
                        'neededRight'    => Right::ID_RIGHT_VEREINSMELDUNG,
                        'allowedMethods' => [] // or [] for all
                    ],
                    'get-altersklassen' => [ // if action is not set, access will be forbidden
                        'neededRight'    => Right::ID_RIGHT_VEREINSMELDUNG,
                        'allowedMethods' => [] // or [] for all
                    ],
                    'get-ligen' => [ // if action is not set, access will be forbidden
                        'neededRight'    => Right::ID_RIGHT_VEREINSMELDUNG,
                        'allowedMethods' => [] // or [] for all
                    ],
                    'confirmclicktt' => [ // if action is not set, access will be forbidden
                        'neededRight'    => Right::ID_RIGHT_VEREINSMELDUNG,
                        'allowedMethods' => [] // or [] for all
                    ],
                    'confirmpokal' => [ // if action is not set, access will be forbidden
                        'neededRight'    => Right::ID_RIGHT_VEREINSMELDUNG,
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
        try {
            $season  = Season::getSeason();
            if($season === null)
                throw new Exception('Keine aktive Saison gefunden/angelegt');
            $modules = $season->vereinsmeldemodule;
            $verein  = Yii::$app->user->identity->verein;
            $vereinsmeldung = Vereinsmeldung::getVereinsmeldungOfVerein($verein, $season);

            return $this->render('index',[
                'modules' => $modules,
                'season'  => $season,
                'verein'  => $verein,
                'vereinsmeldung' => $vereinsmeldung,
            ]);
        }
        catch(\yii\base\Exception $e) {
            Yii::error($e->getMessage(),__METHOD__);
            throw new ServerErrorHttpException($e->getMessage());
        }
    }

    /**
     * Vereinskontakte
     * @param int $p Vereinsmeldung
     */
    public function actionVereinskontakte($p = false)
    {
        try {
            $user   = Yii::$app->user->identity;
            $vereinsmeldung = Vereinsmeldung::find()->where(['id'=>$p])->one();
            if($vereinsmeldung){
                $vereinsmeldungKontakte = VereinsmeldungKontakte::getInstance($vereinsmeldung);
            }
            else {
                throw new Exception('Vereinskontakte können nicht ohne Vereinsmeldung für den Verein '.$user->verein->name.' aufgerufen werden');
            }

            return $this->render('vereinskontakte',[
                'vereinsmeldungKontakte'    => $vereinsmeldungKontakte,
                'vereinsmeldung'            => $vereinsmeldung,
                'user'                      => $user,
            ]);
        }
        catch(\yii\base\Exception $e) {
            Yii::error($e->getMessage(),__METHOD__);
            throw new ServerErrorHttpException($e->getMessage());
        }
    }

    /**
     * Vereinskontakte / Add Person
     * @param int $p Vereinsmeldung
     */
    public function actionAddPerson($p)
    {
        try {
            $vereinsmeldung = Vereinsmeldung::find()->where(['id'=>$p])->one();
            $vereinsmeldungKontakte = $vereinsmeldung->vereinsmeldungKontakte;
            $vereinsrollen          = Vereinsrolle::getVereinsrollen([\app\models\vereinsmeldung\vereinskontakte\Funktionsgruppe::$VEREINSVORSTAND_ID])->select(['name'])->indexBy('id')->column();
            $user   = Yii::$app->user->identity;

            $model = new \app\models\forms\PersonEditForm();
            if($model->load(Yii::$app->request->post()) && $model->validate() ){
                $person = new Person();
                $person = $model->mapToPerson($person);
                if($person->create($vereinsmeldungKontakte) && $model->saveVereinsrollen($person,$vereinsmeldungKontakte)){
                    $this->redirect (['vereinsmeldung/vereinskontakte','p'=>$vereinsmeldung->id]);
                }
                else {
                    Yii::debug(json_encode($person->getErrors()));
                }
            }

            return $this->render('vereinskontakte_addPerson',[
                'vereinsmeldungKontakte'    => $vereinsmeldungKontakte,
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
     * Vereinskontakte / Edit Person
     * @param int $p Person Id
     */
    public function actionEditPerson($p)
    {
        try {
            $person = Person::find()->where(['id'=>$p])->one();
            if($person){
                $vereinsmeldungKontakte = $person->vereinsmeldungKontakte;
                $vereinsmeldung         = $vereinsmeldungKontakte->vereinsmeldung;
                $vereinsrollen          = Vereinsrolle::getVereinsrollen([\app\models\vereinsmeldung\vereinskontakte\Funktionsgruppe::$VEREINSVORSTAND_ID])->select(['name'])->indexBy('id')->column();
                $user                   = Yii::$app->user->identity;

                $model = new \app\models\forms\PersonEditForm();
                $model->mapFromPerson($person);
                if($model->load(Yii::$app->request->post()) && $model->validate() ){
                    $person = $model->mapToPerson($person);
                    if($person->save() && $model->saveVereinsrollen($person,$vereinsmeldungKontakte)){
                        $this->redirect (['vereinsmeldung/vereinskontakte','p'=>$vereinsmeldung->id]);
                    }
                    else {
                        Yii::debug(json_encode($person->getErrors()));
                    }
                }

                return $this->render('vereinskontakte_editPerson',[
                    'vereinsmeldungKontakte'    => $vereinsmeldungKontakte,
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
            $person         = Person::find()->where(['id'=>$p])->one();
            $vereinsmeldung = $person->vereinsmeldungKontakte->vereinsmeldung;
            if($person->deletePerson()){
                $this->redirect (['vereinsmeldung/vereinskontakte','p'=>$vereinsmeldung->id]);
            }
        }
        catch(\yii\base\Exception $e) {
            Yii::error($e->getMessage(),__METHOD__);
            throw new ServerErrorHttpException("Upps...ein Fehler. Die Person kann nicht gelöscht werden.");
        }
    }


    /**
     * Mannschaften melden
     * @param int $p Vereinsmeldung
     */
    public function actionTeams($p = false)
    {
        try {
            $user   = Yii::$app->user->identity;
            $vereinsmeldung = Vereinsmeldung::find()->where(['id'=>$p])->one();
            
            if($vereinsmeldung){
                $vereinsmeldungTeams = VereinsmeldungTeams::getInstance($vereinsmeldung);
            }
            else {
                throw new Exception('Teams können nicht ohne Vereinsmeldung für den Verein '.$user->verein->name.' aufgerufen werden');
            }

            return $this->render('teams',[
                'vereinsmeldung'            => $vereinsmeldung,
                'teams'                     => $vereinsmeldungTeams->teams,
                'user'                      => $user,
            ]);
        }
        catch(\yii\base\Exception $e) {
            Yii::error($e->getMessage(),__METHOD__);
            throw new ServerErrorHttpException($e->getMessage());
        }
    }

    
    /**
     * Teams / Add Team, nur Auswahl der Altersklasse vor Anlegen des Teams
     * 1.Auswahl Altersbereich
     * @param int $p Vereinsmeldung
     */
    public function actionAddTeamAltersbereich($p)
    {
        try {
            $vereinsmeldung = Vereinsmeldung::find()->where(['id'=>$p])->one();
            $vereinsmeldungTeams = $vereinsmeldung->vereinsmeldungTeams;
            $altersbereiche = Altersbereich::find()->select(['name'])->indexBy('id')->column();
            $model          = new \app\models\forms\TeamAltersbereichForm();

            if($model->load(Yii::$app->request->post()) && $model->validate() ){
                $this->redirect (['vereinsmeldung/add-team','p'=>$p,'p2'=>$model->altersbereich_id]);
            }
            
            return $this->render('teams_addteam_altersbereich',[
                'altersbereiche'    => $altersbereiche,
                'model'             => $model,
                'vereinsmeldungTeams'=> $vereinsmeldungTeams,
            ]);
        }
        catch(\yii\base\Exception $e) {
            Yii::error($e->getMessage(),__METHOD__);
            throw new ServerErrorHttpException('Ups...ein Fehler. Der Altersbereich kann nicht gewählt werden.');
        }
    }
    
    /**
     * Teams / Add Team
     * @param int $p Vereinsmeldung
     * @param int $p Altersbereich_id
     */
    public function actionAddTeam($p,$p2)
    {
        try {
            $vereinsmeldung = Vereinsmeldung::find()->where(['id'=>$p])->one();
            $vereinsmeldungTeams = $vereinsmeldung->vereinsmeldungTeams;
            $user   = Yii::$app->user->identity;
            $altersbereich  = Altersbereich::find()->where(['id'=>$p2])->one();
            $altersklassen  = Altersklasse::find()->where(['altersbereich_id'=>$altersbereich->id])->select(['name'])->indexBy('id')->column();
            $ligenzusammenstellung = Ligazusammenstellung::find()->where(['altersbereich_id'=>$altersbereich->id])->one();
            $ligen          = $ligenzusammenstellung->getLigen()->select(['name'])->indexBy('id')->column();
            $regional       = Liga::$regional;

            $model = new \app\models\forms\TeamEditForm();
            $model->altersbereich_id = $altersbereich->id;
            if($altersbereich && $model->load(Yii::$app->request->post()) && $model->validate() ){
                $team = new Team();
                $team = $model->mapToTeam($team);
                if($team->create($vereinsmeldungTeams)){
                    $this->redirect (['vereinsmeldung/teams','p'=>$vereinsmeldung->id]);
                }
                else {
                    Yii::debug(json_encode($team->getErrors()));
                }
            }
            else {
                Yii::debug(json_encode($model->getErrors()));
            }
            return $this->render('teams_addteam',[
                'vereinsmeldungTeams'       => $vereinsmeldungTeams,
                'model'                     => $model,
                'altersbereich'             => $altersbereich,
                'altersklassen'             => $altersklassen,
                'ligen'                     => $ligen,
                'regional'                  => $regional,
            ]);

        }
        catch(\yii\base\Exception $e) {
            Yii::error($e->getMessage(),__METHOD__);
            throw new ServerErrorHttpException('Ups...ein Fehler. Das Team kann nicht angelegt werden.');
        }
        
    }

    /**
     * Teams / Edit Team
     * @param int $p Vereinsmeldung
     * @param int $p2 Team_id
     */
    public function actionEditTeam($p,$p2)
    {
        try {
            $vereinsmeldung = Vereinsmeldung::find()->where(['id'=>$p])->one();
            $vereinsmeldungTeams = $vereinsmeldung->vereinsmeldungTeams;
            $user   = Yii::$app->user->identity;
            $team   = Team::find()->where(['id'=>$p2])->one();
            $altersbereich  = $team->altersklasse->altersbereich;
            $altersklassen  = Altersklasse::find()->where(['altersbereich_id'=>$altersbereich->id])->select(['name'])->indexBy('id')->column();
            $ligenzusammenstellung = Ligazusammenstellung::find()->where(['altersbereich_id'=>$altersbereich->id])->one();
            $ligen          = $ligenzusammenstellung->getLigen()->select(['name'])->indexBy('id')->column();
            $regional       = Liga::$regional;

            $model = new \app\models\forms\TeamEditForm();
            $model->altersbereich_id = $altersbereich->id;
            $model->mapFromTeam($team,$altersbereich);
            if($team && $model->load(Yii::$app->request->post()) && $model->validate() ){
                $team = $model->mapToTeam($team);
                if($team->save()){
                    $this->redirect (['vereinsmeldung/teams','p'=>$vereinsmeldung->id]);
                }
                else {
                    Yii::debug(json_encode($team->getErrors()));
                }
            }
            else {
                Yii::debug(json_encode($model->getErrors()));
            }
            return $this->render('teams_editteam',[
                'vereinsmeldungTeams'       => $vereinsmeldungTeams,
                'model'                     => $model,
                'team'                      => $team,
                'altersbereich'             => $altersbereich,
                'altersklassen'             => $altersklassen,
                'ligen'                     => $ligen,
                'regional'                  => $regional,
            ]);

        }
        catch(\yii\base\Exception $e) {
            Yii::error($e->getMessage(),__METHOD__);
            throw new ServerErrorHttpException('Ups...ein Fehler. Das Team kann nicht angelegt werden.');
        }
        
    }
    
    /**
     * Löschen eines Teams
     * @param int $p Team Id
     */
    public function actionDeleteTeam($p)
    {
        try {
            $team           = Team::find()->where(['id'=>$p])->one();
            if($team){
                $vereinsmeldungTeams = $team->vereinsmeldungTeams;
                $vereinsmeldung = $team->vereinsmeldungTeams->vereinsmeldung;
                if($team->delete()){
                    $vereinsmeldungTeams->checkIsDone();
                    $this->redirect (['vereinsmeldung/teams','p'=>$vereinsmeldung->id]);
                }
            }
        }
        catch(\yii\base\Exception $e) {
            Yii::error($e->getMessage(),__METHOD__);
            throw new ServerErrorHttpException("Upps...ein Fehler. Das Team kann nicht gelöscht werden.");
        }
    }

    /**
     * Teams / Meldet keine Mannschaft im Verein und beendet damit die Mannschafteintragung
     * @param int $p Vereinsmeldung
     */
    public function actionNoTeams($p)
    {
        try {
            $vereinsmeldung = Vereinsmeldung::find()->where(['id'=>$p])->one();
            $vereinsmeldungTeams = $vereinsmeldung->vereinsmeldungTeams;
            
            $vereinsmeldungTeams->setnoteamsflag();
            if($vereinsmeldungTeams->save()){
                $this->redirect (['vereinsmeldung/index','p'=>$vereinsmeldung->id]);
            }
            else
                $this->redirect (['vereinsmeldung/teams','p'=>$vereinsmeldung->id]);
            
        }
        catch(\yii\base\Exception $e) {
            Yii::error($e->getMessage(),__METHOD__);
            throw new ServerErrorHttpException('Ups...ein Fehler. Die Eintragung keiner Teams kann nicht gewählt werden.');
        }
    }

    
    /**
     * Gibt nur die Altersklassen zurück als Input-Radio-Felder um sie z.b. in einen dependent
     * Form nach Auswahl eines Altersbereichs anzuzeigen
     * @param int $p ID des Altersbereichs
     * @param string $p2 Formname fürs inputfeld
     */
    public function actionGetAltersklassen(int $p, string $p2)
    {
        try {
            $altersklassen = Altersklasse::find()->select(['name'])->where(['altersbereich_id'=>$p])->indexBy('id')->column();
            
            if (!empty($altersklassen)) {
                echo \app\models\helpers\FormHelper::getDependentFieldAsRadioListAsLineWithDependentField($altersklassen,'altersklasse_id', ['vereinsmeldung/get-ligen'],'#teameditform-liga_id',$p2 ,'altersklasse');
                exit;
            }
		
        }
        catch(\yii\base\Exception $e) {
            Yii::error($e->getMessage(),__METHOD__);
            throw new ServerErrorHttpException('Ups...ein Fehler. Alterklassen konnten nicht geladen werden.');
        }
    }
    
    /**
     * Gibt nur die Ligen zurück als Input-Radiofelder um sie z.b. in einen dependent
     * Form nach Auswahl eine Altersbereich anzuzeigen
     * @param int $p ID der Altersklasse
     * @param string $p2 Formname fürs inputfeld
     */
    public function actionGetLigen(int $p, string $p2)
    {
        try {
            $altersklasse = Altersklasse::find()->where(['id'=>$p])->one();
            $ligazusammenstellung = Ligazusammenstellung::find()->where(['altersbereich_id'=>$altersklasse->altersbereich_id])->one();
            if($ligazusammenstellung){
                $ligen = $ligazusammenstellung->getLigen()->select(['name'])->indexBy('id')->column();
            }
            if (!empty($ligen)) {
                    echo \app\models\helpers\FormHelper::getDependentFieldAsRadioListAsLine($ligen,'liga_id',$p2);
                    exit;
            }
            else {
                echo '<div class="alert alert-danger">Keine Ligen gefunden.</div>';
            }
		
        }
        catch(\yii\base\Exception $e) {
            Yii::error($e->getMessage(),__METHOD__);
            throw new ServerErrorHttpException('Ups...ein Fehler. Alterklassen konnten nicht geladen werden.');
        }
    }

    
    /**
     * Click-tt Eingabe bestätigen
     * @param int $p Vereinsmeldung
     */
    public function actionConfirmclicktt($p = false)
    {
        try {
            $user   = Yii::$app->user->identity;
            $vereinsmeldung = Vereinsmeldung::find()->where(['id'=>$p])->one();
            
            if($vereinsmeldung){
                $model = VereinsmeldungClickTT::getInstance($vereinsmeldung);
                $model->scenario = "update";
                if($model->load(Yii::$app->request->post()) && $model->validate() ){
                    if($model->save()){
                        $model->checkIsDone();
                        $this->redirect (['vereinsmeldung/index','p'=>$vereinsmeldung->id]);
                    }
                    else {
                        Yii::debug(json_encode($model->getErrors()));
                    }
                }
                else {
                    Yii::debug(json_encode($model->getErrors()));
                }
            }
            else {
                throw new Exception('ClickTT-Bestaetigung kann nicht ohne Vereinsmeldung für den Verein '.$user->verein->name.' aufgerufen werden');
            }

            return $this->render('confirmclicktt',[
                'vereinsmeldung'            => $vereinsmeldung,
                'model'                     => $model,
                'user'                      => $user,
            ]);
        }
        catch(\yii\base\Exception $e) {
            Yii::error($e->getMessage(),__METHOD__);
            throw new ServerErrorHttpException($e->getMessage());
        }
    }
    
    /**
     * Click-tt Eingabe bestätigen
     * @param int $p Vereinsmeldung
     */
    public function actionConfirmpokal($p = false)
    {
        try {
            $user   = Yii::$app->user->identity;
            $vereinsmeldung = Vereinsmeldung::find()->where(['id'=>$p])->one();
            
            if($vereinsmeldung){
                $model = VereinsmeldungPokal::getInstance($vereinsmeldung);
                $model->scenario = "update";
                if($model->load(Yii::$app->request->post()) && $model->validate() ){
                    if($model->save()){
                        $model->checkIsDone();
                        $this->redirect (['vereinsmeldung/index','p'=>$vereinsmeldung->id]);
                    }
                    else {
                        Yii::debug(json_encode($model->getErrors()));
                    }
                }
                else {
                    Yii::debug(json_encode($model->getErrors()));
                }
            }
            else {
                throw new Exception('ClickTT-Pokal-Bestaetigung kann nicht ohne Vereinsmeldung für den Verein '.$user->verein->name.' aufgerufen werden');
            }

            return $this->render('confirmpokal',[
                'vereinsmeldung'            => $vereinsmeldung,
                'model'                     => $model,
                'user'                      => $user,
            ]);
        }
        catch(\yii\base\Exception $e) {
            Yii::error($e->getMessage(),__METHOD__);
            throw new ServerErrorHttpException($e->getMessage());
        }
    }
    
    
}
