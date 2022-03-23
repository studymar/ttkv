<?php
namespace app\models\forms;

use Yii;
use yii\base\Model;
use app\models\user\User;

class LoginForm extends Model {
   
   public $email;
   public $password;
   public $rememberMe = true;
      
   private $_user = null;

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
         [['email'], 'required','message'=>'Bitte gib deine Emailadresse ein.'],
         [['password'], 'required','message'=>'Bitte gib dein Passwort ein.'],
         ['email', 'email', 'message'=>'Bitte trage deine Emailadresse ein'],
         ['password', 'validatePassword' ],
         ['rememberMe', 'boolean' ],
       );
   }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params){
        if(!$this->hasErrors()){
            //Yii::info("Validate Password: ". $this->password);
            $user = $this->getUser();//wird nur neugeladen, wenn noch nicht vorher geladen
            //Yii::debug('Login User: '.$this->username.' / Password: '.$this->password,__METHOD__);
            //Yii::debug("password_hash: ".password_hash($this->password,PASSWORD_DEFAULT),__METHOD__);
            //Yii::debug("password_verify: ".$user->validatePassword($this->password),__METHOD__);
            if(!$user || !$user->validatePassword($this->password)){
                $this->addError('email', 'Email oder Passwort nicht korrekt');
                $this->addError('password', 'Email oder Passwort nicht korrekt');
            }
            else if(!$user->is_validated){
                $this->addError('email', 'Email oder Passwort nicht korrekt');
                $this->addError('password', 'Email oder Passwort nicht korrekt');
            }
            else if($user->locked){
                $this->addError('email', 'User ist deaktiviert');
            }
            else if(!$user->is_validated){
                $this->addError('email', 'User ist nicht aktiv');
            }
        }
    }
   
   public function attributeLabels(){
      return array(
         'email' => 'Benutzername',
         'password' => 'Passwort',
      );
   } 

    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login(){
        if($this->validate()){
            //login
            $user = $this->getUser();
            if($user && $user->validatePassword($this->password)){
                $loginBool = Yii::$app->user->login($user, $this->rememberMe ? 3600*24*30 : 0);
                //authKey setzen
                //$user = $this->getUser();
                return true;
            }
            else {
                //Yii::debug('Login errors: '. var_dump($this->getErrors()));
            }
        }
        return false;
    }
   
    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByEmail($this->email);//email verwendet
            if($this->_user === null){
                Yii::info ('Login erfolglos (User nicht gefunden:'.$this->email.')');
            }
        }

        return $this->_user;
    }   
   
}