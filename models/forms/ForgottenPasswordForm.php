<?php
namespace app\models\forms;

use Yii;
use yii\base\Model;
use app\models\user\User;

class ForgottenPasswordForm extends Model {
   public $email;
   
 
   public function __construct() {
      
   }

         
   public function rules() {
      return array(
         [['email'], 'required','message'=>'Bitte gib deine Emailadresse ein.'],
         ['email', 'email', 'message'=>'Bitte trage deine korrekte Emailadresse ein'],
       );
   }

    
   public function attributeLabels(){
      return array(
         'email' => 'Email',
      );
   } 

    /**
     * Passwort vergessen Mail absenden
     */
    public function sendForgottenPasswordMail(){
        if($this->validate()){
            $user = User::findByEmail($this->email);
            if($user && $user->is_validated && $user->setForgottenPasswordToken()){
                //send mail
                \app\models\mail\MailCollection::sendForgottenPasswordMail($user);
                return true;
            }
            else {
                $this->addError ('email', 'Upps...das hat leider nicht funktioniert.');
                Yii::debug("ForgottenPasswordMail: User nicht gefunden (". $this->email.")", __METHOD__);
            }
        }
        return false;
    }
    

   
}