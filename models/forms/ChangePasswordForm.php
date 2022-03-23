<?php
namespace app\models\forms;

use Yii;
use yii\base\Model;
use app\models\user\User;

class ChangePasswordForm extends Model {
   public $password;
   public $password_repeat;
   
 
   public function __construct() {
      
   }

         
   public function rules() {
      return array(
          
        //[['password','password_repeat'], 'required'],
        [['password','password_repeat'], 'string','length' => [4, 24]],
        [['password_repeat'], 'compare', 'compareAttribute' => 'password', 'message'=>'Die Passwörter stimmen nicht überein.'],
          
       );
   }

   public function attributeLabels(){
      return array(
         'password' => 'Passwort',
         'password' => 'Passwort Wdh.',
      );
   } 

   
}