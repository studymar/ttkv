<?php

namespace app\models\vereinsmeldung\vereinskontakte;

use Yii;
use app\models\vereinsmeldung\IFIsVereinsmeldemodul;
use app\models\vereinsmeldung\Vereinsmeldung;
use app\models\vereinsmeldung\vereinskontakte\Person;

/**
 * This is the model class for table "vereinsmeldung_kontakte".
 *
 * @property int $id
 * @property int $vereinsmeldung_id
 * @property string|null $created_at
 * @property string|null $donedate
 * @property int $done
 *
 * @property Vereinskontakt[] $vereinskontakte
 * @property Person[] $persons
 * @property Vereinsmeldung $vereinsmeldung
 */
class VereinsmeldungKontakte extends \yii\db\ActiveRecord implements IFIsVereinsmeldemodul
{
    private static $instance = null;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vereinsmeldung_kontakte';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'vereinsmeldung_id'], 'required'],
            [['id', 'vereinsmeldung_id','done'], 'integer'],
            [['created_at','donedate'], 'safe'],
            [['id'], 'unique'],
            [['vereinsmeldung_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vereinsmeldung::className(), 'targetAttribute' => ['vereinsmeldung_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'Done' => 'Done?',
            'vereinsmeldung_id' => 'Vereinsmeldung ID',
            'created_at' => 'Created',
        ];
    }

    /**
     * Gets query for [[Vereinskontaktes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVereinskontakte()
    {
        return $this->hasMany(Vereinskontakt::className(), ['vereinsmeldung_kontakte_id' => 'id']);
    }

    /**
     * Gets query for [[Vereinskontaktes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPersons()
    {
        return $this->hasMany(Person::className(), ['vereinsmeldung_kontakte_id' => 'id']);
    }
    
    
    /**
     * Gets query for [[Vereinsmeldung]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVereinsmeldung()
    {
        return $this->hasOne(Vereinsmeldung::className(), ['id' => 'vereinsmeldung_id']);
    }
    

    /**
     * Prueft, ob schon erledigt
     * @return boolean
     */
    public function status(){
        if($this->countPersons() && $this->hasRequiredVereinsrollen())
            return true;
        return false;
    }
    
    /**
     * Prueft, ob schon erledigt
     * @return boolean
     */
    public static function isDone($vereinsmeldung){
        //wenn Eintrag vorhanden und mind. eine Person dazu gespeichert
        $item = self::getInstance($vereinsmeldung);
        if($item && $item->countPersons() && $item->hasRequiredVereinsrollen())
            return true;
        return false;
    }
    
    /**
     * Prueft, ob ein Hinweis zur Meldung angezeigt werden kann, warum der Punkt noch nicht erledigt ist
     * Beispiel: Nur halb ausgefüllt, was muss noch geschehen?
     * @return string
     */
    public static function doneError($vereinsmeldung){
        $item = self::getInstance($vereinsmeldung);
        $count = $item->countPersons();
        if($item && self::isDone($vereinsmeldung))
            return "(".$count." Kontakt". (($count > 1)? "e" : "") . ")";
        //keine 
        else if($item->countPersons() && !$item->hasRequiredVereinsrollen()) {
            return "Es muss mindestens ein Abteilungsleiter als Ansprechpartner angegeben sein.";
        }
        return false;
    }
    
    public static function getInstance($vereinsmeldung){
        if(self::$instance)
            return self::$instance;
        self::$instance = VereinsmeldungKontakte::find()->where(['vereinsmeldung_id'=>$vereinsmeldung->id])->one();
        if(!self::$instance)
            self::$instance = VereinsmeldungKontakte::create($vereinsmeldung);
        return self::$instance;        
    }
    
    /**
     * Anzahl der gespeicherten Kontaktdaten zur Meldung
     * @return int
     */
    public function countPersons(){
        if( $this->vereinskontakte )
            return count($this->vereinskontakte);
        return 0;
    }

    /**
     * Prueft ob zumindest der Abteilungsleiter gepflegt ist
     * @return boolean
     */
    public function hasRequiredVereinsrollen(){
        $count = Vereinskontakt::find()
                ->where(['vereinsmeldung_kontakte_id'=>$this->id])
                ->andWhere(['vereinsrolle_id'=> Vereinsrolle::$ID_ABTEILUNGSLEITER])
                ->count();
        
        if( $count )
            return true;
        return false;
    }

    
    /**
     * Erstellt für eine Vereinsmeldung eine KontaktVereinsmeldung
     * @param type $vereinsmeldung
     * @return VereinsmeldungKontakte|Exception
     */
    public static function create(Vereinsmeldung $vereinsmeldung){
        $item = new VereinsmeldungKontakte();
        $item->id           = 0;
        $item->done         = 0;
        $item->donedate     = null;
        $item->vereinsmeldung_id = $vereinsmeldung->id;
        $item->created_at   = new \yii\db\Expression('NOW()');
        if($item->save()){
            $vereinsmeldung->setStatus(Vereinsmeldung::$STATUS_OPEN);
            return $item;
        }
        Yii::error(\yii\helpers\Json::encode($item->getErrors()));
        return new \yii\base\Exception(\yii\helpers\Json::encode($item->getErrors()));
    }
    
    /**
     * Erstellt für eine Vereinsmeldung eine KontaktVereinsmeldung
     * @param type $vereinsmeldung
     * @return VereinsmeldungKontakte|Exception
     */
    public function addContact(Person $person){
        //Person angelegt, dann Vereinsmeldung begonnen
        $this->vereinsmeldung->setStatus(Vereinsmeldung::$STATUS_STARTED);
    }
    
    /**
     * Prueft und speichert done während des speicherns
     */
    public function checkIsDone(){
        //wenn done und noch nicht gespeichert, dann speichern
        $status = $this->status();
        if($status && !$this->done){
            $this->done     = 1;
            $this->donedate = new \yii\db\Expression('NOW()');
            if( $this->save() )
                return true;
            else
                Yii::error ("VereinsmeldungKontakte Done konnte nicht gespeichert werden",__METHOD__);
        }
        //wenn nicht mehr done, dann speichern
        else if (!$status && $this->done){
            $this->done     = 0;
            $this->donedate = null;
            if( $this->save() )
                return false;
            else
                Yii::error ("VereinsmeldungKontakte Done konnte nicht gespeichert werden",__METHOD__);
        }
        return $status;
            
    }
    
}
