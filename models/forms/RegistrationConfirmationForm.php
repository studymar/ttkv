<?php
namespace app\models\forms;

use Yii;
use yii\base\Model;
use app\models\user\User;
use app\models\helpers\DateCalculator;
use app\models\helpers\DateConverter;

class RegistrationConfirmationForm extends Model {
   public $validationtoken;
   public $user;
   
 
   public function __construct() {
      
   }

         
   public function rules() {
      return array(
         [['validationtoken'], 'required','message'=>'Bitte gib ein Validationtoken ein.'],
         ['validationtoken', 'string','length' => [4, 64],'message'=>'Validationtoken muss ein String sein'],
         ['validationtoken','validateTokenExists'],
          
       );
   }

    public function validateTokenExists($attribute, $params, $validator)
    {
        $this->user = User::findByValidationtoken($this->$attribute);
        if($this->user && !$this->user->is_validated){
            return true;
        }
        Yii::debug("Validationtoken nicht gefunden: ".$this->$attribute);
        $this->addError('validationtoken', 'Die Anmeldung konnte nicht gefunden werden.');
        return false;
    }   


    /**
     * Registrates the user
     */
    public function validateUser(){
        //token nicht zu alt?
        $createdTimestamp = DateConverter::convertToTimestamp($this->user->created);
        if(\app\models\helpers\DateCalculator::isOlderThanXDays($createdTimestamp, 3)){
            $this->addError('validationtoken', "Freischalten der Registration erfolglos weil Registrierung zu lange her.");
            Yii::info("Freischalten der Registration erfolglos weil Registrierung zu lange her: ". json_encode($this->getErrors()),__METHOD__);
            return false;
        }
        
        if($this->user->validateUser())
            return true;
    }
    
    
    
}