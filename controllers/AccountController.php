<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\filters\MyAccessControl;
use yii\filters\VerbFilter;
use app\models\forms\LoginForm;
use app\models\forms\RegistrationForm;
use app\models\Verein;
use yii\web\ForbiddenHttpException;
use app\models\user\User;

class AccountController extends Controller
{
    
    public function behaviors()
    {
        return [
            'access' => [
                'class' => MyAccessControl::class,
                'rules' => [
                    'index' => [ // if action is not set, access will be forbidden
                        'neededRight'    => '',
                        'allowedMethods' => [] // or [] for all
                    ],
                    'anmeldung-abschliessen' => [ // if action is not set, access will be forbidden
                        'neededRight'    => '',
                        'allowedMethods' => [] // or [] for all
                    ],
                    'home' => [ // if action is not set, access will be forbidden
                        'neededRight'    => '+',
                        'allowedMethods' => [] // or [] for all
                    ],
                    'mymenue' => [ // if action is not set, access will be forbidden
                        'neededRight'    => '+',
                        'allowedMethods' => [] // or [] for all
                    ],
                    'logout' => [ // if action is not set, access will be forbidden
                        'neededRight'    => '+',
                        'allowedMethods' => [] // or [] for all
                    ],
                    'reset-password' => [ // if action is not set, access will be forbidden
                        'neededRight'    => '',
                        'allowedMethods' => [] // or [] for all
                    ],
                    // all other actions are allowed
                ],
            ],
        ];
    }
    

    /**
     * Anmelden/Login
     */
    public function actionIndex()
    {
        $model = new \app\models\forms\LoginForm();

        if($model->load(Yii::$app->request->post())){
            if($model->rememberMe == "on")
                $model->rememberMe = 1;
            else
                $model->rememberMe = 0;

            if($model->validate() && $model->login())
                return $this->redirect(['account/home']);

        }

        return $this->render('index',[
            'model' => $model
        ]);
    }

    /**
     * Home im eingeloggten Bereich
     */
    public function actionHome()
    {
        $rightgroups = \app\models\user\Rightgroup::find()->orderBy(['sort'=>SORT_ASC])->all();
        
        $user = User::getLoggedInUser();
        return $this->render('home',[
            'user'          => $user,
            'rightgroups'   => $rightgroups,
        ]);
    }    

    /**
     * MyMenue im eingeloggten Bereich
     */
    public function actionMymenue()
    {
        return $this->render('mymenue',[
        ]);
    }    
    

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }    

    /**
     * Registration 1
     */
    public function actionAnmelden()
    {
        $model = new \app\models\forms\RegistrationForm();
        $model->setFirstStep();
        $isvalidated = false;

        if($model->load(Yii::$app->request->post())){
            //Rueckwärts abgefragt, um bei Validierungsfehlern einfach im vorherigen Step weiter machen zu können 
            //send double-opt-in-info per email
            if($isvalidated || $model->step == "step4"){ 
                $model->scenario = "step4";
                if($model->validate()){
                    //double-opt-in-mail versenden
                    $user = $model->registrate();
                    if($user){
                        \app\models\mail\MailCollection::sendRegistrationMail($user);
                        //weiterleiten zur end-seite
                        return $this->redirect(['account/anmeldung-bestaetigen']);
                    }
                }
                $model->step = "step3";
                $isvalidated = true;
            }
            //bestaetigen
            if($model->step == "step3"){ 
                $model->scenario = "step3";
                if($isvalidated || $model->validate()){
                    $verein = Verein::find()->where(['id'=>$model->vereins_id])->one();
                    return $this->render('anmelden-3', [
                        'model' => $model,
                        'verein'=> $verein,
                    ]);
                }
                else $model->step = "step2";
                $isvalidated = true;
            }
            
            //select organisation
            if($model->step == "step2"){
                $model->scenario = "step2";
                if($isvalidated || $model->validate()){
                    $isvalidated = true;
                    $vereine = Verein::find()->orderBy('ort')
                        ->select(['name'])
                        ->indexBy('id')
                        ->column();
                    
                    return $this->render('anmelden-2', [
                        'model'     => $model,
                        'vereine'   => $vereine
                    ]);
                }
                else $model->step = "step1";
                $isvalidated = true;
            }
        }
        
        $model->scenario = "step1";
        return $this->render('anmelden-1', [
            'model' => $model,
        ]);
    }

    /**
     * Registration letzte Seite
     */
    public function actionAnmeldungBestaetigen()
    {
        return $this->render('anmeldung-bestaetigen', [
        ]);
    }

    /**
     * Registrierung Link aus Email geklickt
     * @param string $p
     */
    public function actionAnmeldungAbschliessen($p)
    {
        $model = new \app\models\forms\RegistrationConfirmationForm();
        $model->validationtoken = $p;
        if($model->validate() && $model->validateUser()){
            return $this->redirect(['account/anmeldung-abgeschlossen']);
        }

        //nicht erfolgreich Fehler ausgeben
        return $this->render('anmeldung-abschliessen-error', [
            'model' => $model
        ]);
    }

    /**
     * Registrierung Email bestaetigt
     * @return type
     */
    public function actionAnmeldungAbgeschlossen()
    {
        return $this->render('anmeldung-abgeschlossen', [
        ]);
    }

 
    /**
     * Passwort vergessen
     */
    public function actionForgottenPassword()
    {
        $model = new \app\models\forms\ForgottenPasswordForm();

        if($model->load(Yii::$app->request->post())){
            if($model->validate() && $model->sendForgottenPasswordMail())
                return $this->redirect(['account/forgotten-password-success']);
        }

        return $this->render('forgotten-password',[
            'model' => $model
        ]);
    }

    /**
     * Passwort vergessen - Success
     * @return type
     */
    public function actionForgottenPasswordSuccess()
    {
        return $this->render('forgotten-password-success', [
        ]);
    }

    /**
     * Passwort neu setzen nach Passwort vergessen
     * @param string $p Token
     * @return type
     */
    public function actionResetPassword($p)
    {
          $model = new \app\models\forms\ForgottenPasswordResetForm();
          $model->scenario = "startwithtoken";
          $model->passwordforgottentoken = $p;
          if($model->validate()){
            $model->scenario = "resetpassword";
            if($model->load(Yii::$app->request->post()) && $model->validate()){
                $model->resetPassword();
                return $this->redirect(['account/forgotten-password-reset-success']);
            }
            Yii::debug(json_encode(Yii::$app->request->post()));
            return $this->render('forgotten-password-reset', [
                'model' => $model,
            ]);
        }
        else
            Yii::debug ("reset-password token falsch: ".json_encode($model->getErrors()), __METHOD__);

        if($model->hasErrors() && $model->getErrors('passwordforgottentoken')){
            //token zu alt oder unbekannt?
            throw new ForbiddenHttpException("Forbidden: ".var_dump($model->getErrors('passwordforgottentoken')));
        }
        throw new ForbiddenHttpException("Forbidden");
    }

    /**
     * Passwort vergessen - Reset Passwird Success
     */
    public function actionForgottenPasswordResetSuccess()
    {
        return $this->render('forgotten-password-reset-success', [
        ]);
    }
    

    /**
     * MyData im eingeloggten Bereich
     */
    public function actionMydata()
    {
        $model  = new \app\models\forms\MyDataEditForm();
        $user   = Yii::$app->user->identity; 
        
        $model->mapFromUser($user);

        if($model->load(Yii::$app->request->post()) && $model->validate() ){
            $user = $model->mapToUser($user);
            if($user->save())
                $this->redirect (['account/home']);
        }

        $modelPW  = new \app\models\forms\ChangePasswordForm();
        if($modelPW->load(Yii::$app->request->post()) && $modelPW->validate() ){
            if($user->changePassword($modelPW->password))
                $this->redirect (['account/home']);
        }
        
        return $this->render('mydata',[
            'model'     => $model,
            'user'      => $user,
            'modelPW'   => $modelPW,
        ]);
    }    

    
}
