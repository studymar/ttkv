<?php
namespace app\models\forms;

use Yii;
use yii\base\Model;
use app\models\user\User;
use app\models\helpers\DateCalculator;
use app\models\helpers\DateConverter;

class ForgottenPasswordResetForm extends Model {
   public $passwordforgottentoken;
   public $user;
   public $password;
   public $password_repeat;

   public function __construct() {
      
   }

         
   public function rules() {
      return array(
          //scenario startwithtoken
         [['passwordforgottentoken'], 'required','message'=>'Der Passwort-Vergessen-Link ist nicht korrekt', 'on'=>'startwithtoken'],
         ['passwordforgottentoken', 'string','length' => [4, 64],'message'=>'Passwort-Vergessen muss ein String sein', 'on'=>'startwithtoken'],
         ['passwordforgottentoken','validateTokenExists', 'on'=>'startwithtoken'],

          //scenario startwithtoken
         ['passwordforgottentoken','safe', 'on'=>'resetpassword'],
         [['password','password_repeat'], 'required','message'=>'Bitte gib dein Passwort ein.', 'on'=>'resetpassword'],
         [['password'], 'compare', 'compareAttribute'=>'password_repeat' , 'message'=>'Die Passwörter stimmen nicht überein.', 'on'=>'resetpassword'],
          
       );
   }

    public function validateTokenExists($attribute, $params, $validator)
    {
        $this->user = User::findByPasswordForgottenToken($this->$attribute);
        if($this->user && $this->user->is_validated){
            if($this->checkPasswordForgottenDate())
                return true;
            else {
                return false;
            }
        }
        Yii::debug("passwordforgottentoken nicht gefunden: ".$this->$attribute);
        $this->addError('passwordforgottentoken', 'Der Passwort-vergessen Link konnte nicht gefunden werden.');
        return false;
    }   


    /**
     * Prüft, ob Passwort vergessen schon zu alt (max. 3 Tage) ist
     * @param User $user
     */
    public function checkPasswordForgottenDate(){
        if($this->user->passwordforgottendate){
            $timestamp = DateConverter::convertToTimestamp($this->user->passwordforgottendate);
            if(\app\models\helpers\DateCalculator::isOlderThanXDays($timestamp, 3)){
                Yii::debug("passwordforgottentoken zu alt: ".$this->user->passwordforgottendate. "/ User: ".$this->user->getName());
                $this->addError('passwordforgottentoken', "Der Link aus der Email ist zu alt, bitte fülle das Formular neu aus.");
                return false;
            }
            return true;
        }
        return false;
    }    

    public function resetPassword(){
        if($this->user->resetPassword($this->password))
            return true;
        return false;
    }
    
}