<?php
namespace app\models\forms;

use Yii;
use yii\base\Model;
use app\models\user\User;

class MyDataEditForm extends Model {
   public $id;
   public $email;
   public $firstname;
   public $lastname;
   public $vereins_id;
   public $role_id;
   public $locked;
   
 
   public function __construct() {
      
   }

         
   public function rules() {
      return array(
          
         [['email'], 'required','message'=>'Bitte gib eine Emailadresse ein.'],
         ['email', 'email', 'message'=>'Bitte trage eine korrekte Emailadresse ein'],
         ['email','validateEmailDoesNotExist'],
         [['firstname'], 'required','message'=>'Bitte gib einen Vornamen ein.'],
         [['lastname'], 'required','message'=>'Bitte gib einen Nachnamen ein.'],
         //[['vereins_id'], 'required', 'message'=>'Bitte wähle einen Verein aus.'],
          
       );
   }

    public function validateEmailDoesNotExist($attribute, $params, $validator)
    {
        $user = User::findByEmail($this->$attribute);
        if($user && $user->id != $this->id ){ //nur verhindern, wenn bei anderem User bereits vorhanden
            Yii::debug("User EDIT Validierung false, Email already exists: ".$this->$attribute);
            $this->addError('email', 'Email existiert bereits.');
            return false;
        }
        return true;
    }   

    
   public function attributeLabels(){
      return array(
         'email' => 'Benutzername',
         'password' => 'Passwort',
         'vereins_id' => 'Verein',
      );
   } 

    public function mapFromUser($user)
    {
        $this->id           = $user->id;
        $this->vereins_id   = $user->vereins_id;
        $this->firstname    = $user->firstname;
        $this->lastname     = $user->lastname;
        $this->email        = $user->email;
        
    }   
    public function mapToUser($user)
    {
        $user->id           = $this->id;
        $user->vereins_id   = $this->vereins_id;
        $user->firstname    = $this->firstname;
        $user->lastname     = $this->lastname;
        $user->email        = $this->email;
        return $user;
    }   

   
}