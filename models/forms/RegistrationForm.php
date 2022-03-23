<?php
namespace app\models\forms;

use Yii;
use yii\base\Model;
use app\models\user\User;

class RegistrationForm extends Model {
   public $email;
   public $firstname;
   public $lastname;
   public $password;
   public $password_repeat;
   public $vereins_id;
   public $step = "step1";
   public $confirm;
   
 
   public function __construct() {
      
   }

         
   public function rules() {
      return array(
          /*
         array('email, password', 'required','message'=>'Bitte füllen Sie die Felder aus.'),
         array('email, password', 'match', 'pattern'=>'/^([a-zA-Z0-9_])/','message'=>'{attribute} enthält unerlaubte Zeichen.'),
         array('email', 'email', 'message'=>'Bitte geben Sie eine gültige Emailadresse ein.'),
         array('password', 'length', 'min'=>3, 'max'=>40, 'tooShort'=>'{attribute} muss zwischen {min} und {min} Zeichen lang sein.', 'tooLong'=>'{attribute} muss zwischen {min} und {min} Zeichen lang sein.'),
          */
         [['step'], 'required','message'=>'Deine Eingaben konnten nicht überprüft werden.'],
          
          /*
           * Scenario Step 1+2
           */
         [['email'], 'required','message'=>'Bitte gib deine Emailadresse ein.'],
         ['email', 'email', 'message'=>'Bitte trage deine korrekte Emailadresse ein'],
         ['email','validateEmailDoesNotExist'],
         [['firstname'], 'required','message'=>'Bitte gib deinen Vornamen ein.'],
         [['lastname'], 'required','message'=>'Bitte gib deinen Nachnamen ein.'],
         [['password','password_repeat'], 'required','message'=>'Bitte gib dein Passwort ein.'],
         [['password'], 'compare', 'compareAttribute'=>'password_repeat' , 'message'=>'Die Passwörter stimmen nicht überein.'],
         ['vereins_id', 'safe', 'on'=> ['step1','step2']],
         ['confirm', 'safe', 'on'=> ['step1','step2']],
          
          
          /*
           * Scenario Step 3 + step4
           */
         ['vereins_id', 'required', 'message'=>'Bitte wähle deinen Verein aus.', 'on'=> ['step3','step4']],
         ['vereins_id', 'integer', 'message'=>'Bitte wähle deinen Verein aus.', 'on'=> ['step3','step4']],
         ['confirm', 'safe', 'on'=> ['step1','step2','step3']],
          
          /*
           * Scenario Confirm
           */
         ['confirm', 'required', 'message'=>'Bitte bestätige deine Angaben.', 'on'=> ['step4']],
         ['confirm', 'integer', 'message'=>'Bitte bestätige deine Angaben.', 'on'=> ['step4']],
          
       );
   }

    public function validateEmailDoesNotExist($attribute, $params, $validator)
    {
        $user = User::findByEmail($this->$attribute);
        if($user){
            Yii::debug("Anmelden Validierung false, Email already exists: ".$this->$attribute);
            $this->addError('email', 'Deine Email kann nicht erneut angemeldet werden. Bitte nutze stattdessen die Passwort vergessen-Funktion.');
            return false;
        }
        return true;
    }   

    /*
    public function validateEmailIsActive($attribute, $params, $validator)
    {
        $user = User::findByEmail($attribute);
        if(!$user->is_validated){
            $this->addError('email', 'Dieser Benutzer ist noch nicht aktiviert.');
            return false;
        }
        if($user->locked){
            $this->addError('email', 'Dieser Benutzer ist zur Zeit nicht aktiv.');
            return false;
        }
        return true;
    } 
     */  
    
   public function attributeLabels(){
      return array(
         'email' => 'Benutzername',
         'password' => 'Passwort',
      );
   } 

    /**
     * Registrates the user
     */
    public function registrate(){
        if($this->validate()){
            $user = User::createUser($this->firstname, $this->lastname, $this->email, $this->password, $this->vereins_id);
            if($user){
                Yii::debug (json_encode($user->attributes), __METHOD__);
                return $user;
            }
            else {
                $this->addError ('confirm', 'Upps...das Anmelden funktioniert zur Zeit nicht, bitte versuche es später nochmal.');
                Yii::debug("Registrate errors: User konnte nicht angelegt werden. ". json_encode($user), __METHOD__);
            }
        }
        Yii::debug('Registrate errors: '. json_encode($this->getErrors()),__METHOD__);
        return false;
    }
    
    
    /**
     * Set next Step
     */
    public function setNextStep(){
        switch ($this->step){
            case "step1":
                $this->step = "step2";
                $this->scenario = "step2";
                break;
            case "step2":
                $this->step = "step3";
                $this->scenario = "step3";
                break;
            case "step3":
                $this->step = "confirm";
                $this->scenario = "confirm";
                break;
            default:
                $this->setFirstStep();
                break;
        }
    }    
    
    /**
     * Set next Step
     */
    public function setLastStep(){
        switch ($this->step){
            case "step2":
                $this->step = "step1";
                $this->scenario = "step1";
                break;
            case "step3":
                $this->step = "step2";
                $this->scenario = "step2";
                break;
            case "confirm":
                $this->step = "step3";
                $this->scenario = "step3";
                break;
            default:
                $this->setFirstStep();
                break;
        }
    }    

    /**
     * Set next Step
     */
    public function setFirstStep(){
            $this->step = "step1";
            $this->scenario = "step1";
    }
    
}