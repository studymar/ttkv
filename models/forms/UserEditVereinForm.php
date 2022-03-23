<?php
namespace app\models\forms;

use Yii;
use yii\base\Model;
use app\models\user\User;

class UserEditVereinForm extends Model {
   public $vereins_id;
   
 
   public function __construct() {
      
   }

         
   public function rules() {
      return array(
          
         ['vereins_id', 'required', 'message'=>'Bitte wähle einen Verein aus.'],
         ['vereins_id', 'integer', 'message'=>'Bitte wähle einen Verein aus.'],
          
       );
   }

   public function attributeLabels(){
      return array(
         'vereins_id' => 'Verein',
      );
   } 

    public function mapFromUser($user)
    {
        $this->vereins_id   = $user->vereins_id;
        
    }   
    public function mapToUser($user)
    {
        $user->vereins_id   = $this->vereins_id;
        return $user;
    }   

   
}