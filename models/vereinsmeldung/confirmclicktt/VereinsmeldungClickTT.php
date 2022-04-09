<?php

namespace app\models\vereinsmeldung\confirmclicktt;

use Yii;
use app\models\vereinsmeldung\IFIsVereinsmeldemodul;
use app\models\vereinsmeldung\Vereinsmeldung;

/**
 * This is the model class for table "vereinsmeldung_click_tt".
 *
 * @property int $id
 * @property int $done
 * @property string|null $created_at
 * @property string|null $donedate
 * @property int $vereinsmeldung_id
 * @property int $noteamsflag
 *
 * @property Vereinsmeldung $vereinsmeldung
 */
class VereinsmeldungClickTT extends \yii\db\ActiveRecord implements IFIsVereinsmeldemodul
{

    private static $instance = null;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vereinsmeldung_click_tt';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'vereinsmeldung_id'], 'required'],
            [['id', 'vereinsmeldung_id'], 'integer'],
            //nur bei save, bei create kann auch 0 sein
            [['done'], 'integer','min'=>1, 'max'=>'1',"tooSmall"=>"Bitte gib zuerst die Vereinsmeldung in Click-tt ein", "on"=>"update"],
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
            'done'      => 'In Click-tt eingegeben',
        ];
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
        self::$instance = VereinsmeldungClickTT::find()->where(['vereinsmeldung_id'=>$vereinsmeldung->id])->one();
        if(!self::$instance)
            self::$instance = VereinsmeldungClickTT::create($vereinsmeldung);
        return self::$instance;        
    }

    /**
     * Prueft, ob schon erledigt
     * @return boolean
     */
    public function status(){
        if($this->done )
            return true;
        return false;
    }    
    
    /**
     * Prueft, ob schon erledigt
     * @return boolean
     */
    public static function isDone($vereinsmeldung){
        //wenn Eintrag vorhanden dazu gespeichert
        $item = self::getInstance($vereinsmeldung);
        if($item && $item->done)
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
     * Erstellt für eine Vereinsmeldung eine VereinsmeldungClickTT
     * @param type $vereinsmeldung
     * @return VereinsmeldungTeams|Exception
     */
    public static function create(Vereinsmeldung $vereinsmeldung){
        Yii::debug("Create VereinsmeldungClickTT for vereinsmeldung_id ".$vereinsmeldung->id, __METHOD__);
        $item = new VereinsmeldungClickTT();
        $item->id           = 0;
        $item->done         = 0;
        $item->donedate     = null;
        $item->vereinsmeldung_id = $vereinsmeldung->id;
        $item->created_at   = new \yii\db\Expression('NOW()');
        if($item->save())
            return $item;
        Yii::error(\yii\helpers\Json::encode($item->getErrors()));
        return new \yii\base\Exception(\yii\helpers\Json::encode($item->getErrors()));
    }
    
    public function setdone(){
        $this->done  = 1;
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
                Yii::error ("VereinsmeldungPokal Done konnte nicht gespeichert werden",__METHOD__);
        }
        //wenn nicht mehr done, dann speichern
        else if (!$status && $this->done){
            $this->done     = 0;
            $this->donedate = null;
            if( $this->save() )
                return false;
            else
                Yii::error ("VereinsmeldungClickTT Done konnte nicht gespeichert werden",__METHOD__);
        }
        return $status;
            
    }

    
}
