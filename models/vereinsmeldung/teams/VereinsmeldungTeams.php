<?php

namespace app\models\vereinsmeldung\teams;

use Yii;
use app\models\vereinsmeldung\IFIsVereinsmeldemodul;
use app\models\vereinsmeldung\Vereinsmeldung;

/**
 * This is the model class for table "vereinsmeldung_teams".
 *
 * @property int $id
 * @property int $done
 * @property string|null $created_at
 * @property string|null $donedate
 * @property int $vereinsmeldung_id
 * @property int $noteamsflag
 *
 * @property Team[] $teams
 * @property Vereinsmeldung $vereinsmeldung
 */
class VereinsmeldungTeams extends \yii\db\ActiveRecord implements IFIsVereinsmeldemodul
{

    private static $instance = null;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vereinsmeldung_teams';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'vereinsmeldung_id'], 'required'],
            [['id', 'vereinsmeldung_id','noteamsflag','done'], 'integer'],
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
            'created_at' => 'Created At',
            'vereinsmeldung_id' => 'Vereinsmeldung ID',
        ];
    }

    /**
     * Gets query for [[Teams]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTeams()
    {
        return $this->hasMany(Team::className(), ['vereinsmeldung_teams_id' => 'id'])->orderBy('altersklasse_id');
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

    
    public static function getInstance($vereinsmeldung){
        if(self::$instance)
            return self::$instance;
        self::$instance = VereinsmeldungTeams::find()->where(['vereinsmeldung_id'=>$vereinsmeldung->id])->one();
        if(!self::$instance)
            self::$instance = VereinsmeldungTeams::create($vereinsmeldung);
        return self::$instance;        
    }

    /**
     * Prueft, ob schon erledigt
     * @return boolean
     */
    public function status(){
        if(count($this->teams) || $this->noteamsflag )
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
        if($item->noteamsflag || count($item->teams)>0)
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
        return false;
    }

    
    /**
     * Erstellt für eine Vereinsmeldung eine VereinsmeldungTeams
     * @param type $vereinsmeldung
     * @return VereinsmeldungTeams|Exception
     */
    public static function create(Vereinsmeldung $vereinsmeldung){
        Yii::debug("Create VereinsmeldungTeams for vereinsmeldung_id ".$vereinsmeldung->id, __METHOD__);
        $item = new VereinsmeldungTeams();
        $item->id           = 0;
        $item->done         = 0;
        $item->donedate     = null;
        $item->noteamsflag  = 0;
        $item->vereinsmeldung_id = $vereinsmeldung->id;
        $item->created_at   = new \yii\db\Expression('NOW()');
        if($item->save())
            return $item;
        Yii::error(\yii\helpers\Json::encode($item->getErrors()));
        return new \yii\base\Exception(\yii\helpers\Json::encode($item->getErrors()));
    }
    
    public function setnoteamsflag(){
        $this->noteamsflag  = 1;
        $this->done         = 1;
        $this->donedate     = new \yii\db\Expression('NOW()');
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
                Yii::error ("VereinsmeldungTeams Done konnte nicht gespeichert werden",__METHOD__);
        }
        //wenn nicht mehr done, dann speichern
        else if (!$status && $this->done){
            $this->done     = null;
            $this->donedate = null;
            if( $this->save() )
                return false;
            else
                Yii::error ("VereinsmeldungTeams Done konnte nicht gespeichert werden",__METHOD__);
        }
        return $status;
            
    }
    
    
}
