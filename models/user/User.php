<?php

namespace app\models\user;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\web\IdentityInterface;
use app\models\user\Role;
use app\models\user\Right;
use app\models\mail\MailCollection;
use app\models\helpers\DateConverter;
use app\models\helpers\DateCalculator;
use app\models\Verein;

/**
 * This is the model class for table "User".
 *
 * @property integer $id
 * @property integer $is_validated
 * @property string $validationtoken
 * @property string $lastname
 * @property string $firstname
 * @property string $email
 * @property string $password
 * @property string $passwordforgottentoken
 * @property string $passwordforgottendate

 * @property string $lastlogindate
 * @property string $created
 * @property int $locked
 * @property string $lockeddate
 * @property integer $role_id
 * @property integer $vereins_id
 * 
 * @property Role $role
 * 
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    //only for registrationform
    public $password_repeat; // wird bei registrierung verwendet
    public $rolename; //wird in userlist/index verwendet

    protected static $user;

        /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email','lastname','firstname','role_id','vereins_id','is_validated','created'], 'required'],
            [['validationtoken', 'email'], 'string', 'max' => 100],

            [['validationtoken'], 'required', 'on'=>'create'],
            
            
            [['password','password_repeat'], 'required', 'on'=>'passwordchange'],
            [['password','password_repeat'], 'required', 'on'=>'create'],

            [['lastname', 'firstname', 'password','password_repeat'], 'string'],
            [['email'], 'unique', 'message'=>'Die Email ist bereits verwendet.','on'=>'create'],
            [['email'], 'email','message'=>'Bitte tragen Sie Ihre reale Emailadresse ein.'],
            [['password_repeat'], 'compare', 'compareAttribute' => 'password', 'message'=>'Die Passwörter stimmen nicht überein.', 'on'=>'create'],
            [['lastlogindate','lockeddate', 'locked','created','passwordforgottentoken','passwordforgottendate'], 'safe'],
            [['validationtoken'], 'unique'],
            [['role_id'], 'integer'],
            [['role_id'], 'exist', 'targetClass' => Role::className(), 'targetAttribute' => 'id'],
            [['vereins_id'], 'exist', 'skipOnError' => true, 'targetClass' => Verein::className(), 'targetAttribute' => ['vereins_id' => 'id']],
            [['is_validated'], 'integer'],
            
            //[['rolename'], 'match', 'pattern'=>'/^([a-zA-Z0-9_])/','message'=>'{attribute} enthält unerlaubte Zeichen.'],
            //[['rolename'], 'string', 'max' => 256],            

        ];
    }
    
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created',
                'updatedAtAttribute' => false,
                'value' => new Expression('NOW()'),
            ]
        ];
    }    

    /*
    public function validate($attributeNames = NULL, $clearErrors = true){
        $this->email = $this->email;
        return parent::validate();
    }
    */
    /*
    public function validateUsername($attribute, $params, $validator)
    {
        if (User::findByUsername($this->$attribute) !== null) {
            $this->addError($attribute, $validator->message);
        }
    }    
    */
    public function getId() {
        return $this->id;
    }

    
    public function getAuthKey() {
        return $this->email;
    }

    public function validateAuthKey($authKey) {
        return $this->email === $authKey;
    }

    /**
     * Wird bei jedem Aufruf aufgerufen, User gefunden
     * @param int $id
     * @return User || null
     */
    public static function findIdentity($id) {
        $user = self::findOne($id);
        return $user;
    }

    public static function findIdentityByAccessToken($token, $type = null) {
        //throw new \yii\base\NotSupportedException;
        return static::findOne(['token' => $token, 'locked'=>null]);
    }
    /*
    public static function findIdentityByAuthKey($token) {
        //throw new \yii\base\NotSupportedException;
        return static::findOne(['token' => $token, 'locked'=>null]);
    }
    */

    public function validatePassword($password) {
        //$hash = password_hash($password, PASSWORD_DEFAULT);
        //Yii::info('ValidatePassword: '.$hash.' = '.$this->password);
        //throw new ServerErrorHttpException("Internal Server Error. Please try again later.");
        //return $this->password === sha1($password);
        return password_verify($password, $this->password);
    }
    public static function findByEmail($email) {
        Yii::debug("Email: ".$email, __METHOD__);
        return self::findOne(['email' => $email]);
    }
    public static function findByValidationtoken($token) {
        return self::findOne(['validationtoken' => $token]);
    }
    public static function findByPasswordForgottenToken($token) {
        return self::findOne(['passwordforgottentoken' => $token]);
    }



    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(Role::className(), ['id' => 'role_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVerein()
    {
        return $this->hasOne(Verein::className(), ['id' => 'vereins_id']);
    }

    
    /**
     * Erstellt einen User
     * @return boolean
     */
    public static function createUser($firstname,$lastname, $email, $password, $vereins_id){
        $user = new User();
        $user->firstname    = $firstname;
        $user->lastname     = $lastname;
        $user->email        = $email;
        $user->password     = $password;
        $user->vereins_id   = $vereins_id;
        $user->created      = new Expression("NOW()");

        //validationtoken per zufall setzen
        //gesetzt = Registrierung noch nicht abgeschlossen
        //$this->validationtoken  = \yii\helpers\Html::encode(password_hash(\Yii::$app->security->generateRandomString(), PASSWORD_BCRYPT),true);
        $user->validationtoken   = \yii\helpers\Html::encode(\Yii::$app->security->generateRandomString());
        $user->is_validated      = 0;
        $user->role_id = 1;//Standard
        if($user->validate()){
            //nach validierung, passwörter verschlüsseln und user anlegen
            $hash = password_hash($user->password, PASSWORD_DEFAULT);
            $user->password         = $hash;
            $user->password_repeat  = $hash;
            if($user->save())
                return $user;
        }
        else 
            Yii::debug (json_encode($user->getErrors()), __METHOD__);
        return false;
    }
    
    /**
    public function sendRegistrationMail(){
        return MailCollection::sendRegistrationMail($this);
        
    }
     */
    
    /**
     * Prüft ob es einen User mit diesem Validierungstoken gibt, der noch nicht validiert ist.
     * Null, if not found.
     * @param string $token
     * @return boolean
     *
    public static function validateUser($token) {
        $item = self::findByValidationtoken(\yii\helpers\Html::decode($token));
        //gefunden und korrekt noch nicht validiert?
        if(!is_null($item)){
            if(!$item->is_validated){
                $createdTimestamp = DateConverter::convertToTimestamp($item->created);
                if(\app\models\helpers\DateCalculator::isOlderThanXDays($createdTimestamp, 3)){
                    Yii::info("Freischalten der Registration erfolglos weil Registrierung zu lange her: ". json_encode($item->getErrors()),__METHOD__);
                    throw new \yii\base\ErrorException('Ihre Registrierung ist zu lange her, bitte registrieren Sie sich erneut.');
                }
                //validierung eintragen
                $item->is_validated = 1;
                if($item->save()){
                    //Yii::info('User erfolgreich freigeschaltet: User ID '.$item->id, __METHOD__);
                    return true;
                }
                else {
                    Yii::error("Fehler beim Freischalten der Registration: ". json_encode($item->getErrors()),__METHOD__);
                    throw new \yii\base\ErrorException('Fehler: Ihre Bestätigung konnte nicht gepeichert werden, versuchen Sie es später nochmal.');
                }
            }
            else {
                Yii::warning('User hat erneut versucht Account freizuschalten mit RegistrationToken: '.$token,__METHOD__);
                throw new \yii\base\ErrorException('Ihr Account ist bereits bestätigt.');
            }
        }
        else {
            Yii::warning('Registrierung kann nicht freigeschaltet werden wegen unbekanntem/falschem mit unbekanntem Registrationtoken: '.$token,__METHOD__);
            throw new \yii\base\Exception('Fehler: Registrierung nicht gefunden.');
        }
        return false;
    }

    /**
     * Validiert den User anhand des Validationtoken
     * @return boolean
     */
    public function validateUser() {
        //validierung eintragen
        $this->is_validated = 1;
        if($this->save()){
            //Yii::info('User erfolgreich freigeschaltet: User ID '.$this->id, __METHOD__);
            return true;
        }
        else {
            Yii::error("Fehler beim Freischalten der Registration: ". json_encode($this->getErrors()),__METHOD__);
            throw new \yii\base\ErrorException('Fehler: Ihre Bestätigung konnte nicht gepeichert werden, versuchen Sie es später nochmal.');
        }
    }    

    /**
     * Prüft, ob der User ein Recht hat
     * @param int $rightId
     * @return boolean
     */
    public function hasRight($rightId) {
        if($this->locked !== null) return false;
        return $this->role->hasRight($rightId);
    }    
    
    /**
     * Prüft ob eingeloggt und ob Recht vorhanden
     * @param int $rightId
     * @return boolean
     */
    public static function checkRight($rightId) {
        if(!Yii::$app->user->isGuest){
            $user = Yii::$app->user->identity;
            return $user->hasRight($rightId);
        }
        return false;
    }
    
    /**
     * Setzt lastLogin-Date und speichert
     * @param boolean $withSave [default:true] Speichern lässt sich ausschalten, falls im Controller
     * bereits der User gespeichert wird, um doppeltes Speichern zu verhindenr
     */
    public function updateLastlogin($withSave = true) {
        $this->lastlogindate = new Expression('NOW()');
        if($withSave)
            $this->update();
    }
    
    public function getUser(){
        return User::findIdentity(Yii::$app->user->identity->id);
    }
    public static function getLoggedInUser(){
        if(self::$user === null)
            self::$user = User::findIdentity(Yii::$app->user->identity->id);
        return self::$user;
    }

    public function getName(){
        return $this->firstname." ".$this->lastname;
    }

    /**
     * Setzt ein neues, zufälliges Passwort
     * @return boolean|string
     *
    public function resetPassword(){
        $newPassword = "P".rand(10000000, 99999999);
        $hash = password_hash($newPassword, PASSWORD_DEFAULT);
        $this->password         = $hash;
        
        if($this->save())
            return $newPassword;
        return false;
    }

    /**
     * Setzt ein neues Passwort
     * @param String $password
     * @return boolean|string
     */
    public function resetPassword($password){
        $this->scenario = "passwordchange";
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $this->password                 = $hash;
        $this->password_repeat          = $hash;
        
        return $this->save();
    }


    public function setForgottenPasswordToken(){
        $this->passwordforgottentoken   = \yii\helpers\Html::encode(\Yii::$app->security->generateRandomString());
        $this->passwordforgottendate    = new Expression('NOW()');
        if($this->save())
            return true;
        Yii::debug("Error: ". json_encode($this->getErrors()),__METHOD__);
        return false;
    }
    public function sendResetPasswordMail($newPassword){
        return MailCollection::sendResetPasswordMail($this, $newPassword);        
    }
    
    
    /**
     * Sperrt den User (kein Login mehr möglich)
     * @return boolean|string
     */
    public function lock(){
        $this->locked         = 1;
        $this->lockeddate     = new Expression('NOW()');
        if($this->save())
            return true;
        return false;
    }    

    /**
     * Entsperrt den User
     * @return boolean|string
     */
    public function unlock(){
        $this->locked         = 0;
        $this->lockeddate     = new Expression('NULL');
        if($this->save())
            return true;
        return false;
    }    

    public function search(){
        $search = User::find();
        $search->where("user.locked is null and is_validated = 1");

        $search->joinWith(['role']);
        
        if($this->id != null)
            $search->andWhere(['like','id',$this->id]);
        if($this->lastname != null)
            $search->andWhere(['like','lastname',$this->lastname]);
        if($this->firstname != null)
            $search->andWhere(['like','firstname',$this->firstname]);
        if($this->email != null)
            $search->andWhere(['like','email',$this->email]);
        if($this->rolename != null)
            $search->andWhere(['like','role.name',$this->rolename]);
        return $search;
    }    
    
    /**
     * Ändert das Passwort des Users
     * @param string $password
     * @return boolean
     */
    public function changePassword($password){
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $this->password         = $hash;
        $this->password_repeat  = $hash;
        if($this->save())
            return true;
        return false;
    }    
    
    
}
