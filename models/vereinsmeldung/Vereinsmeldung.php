<?php

namespace app\models\vereinsmeldung;

use Yii;
use app\models\Vereinsmeldung\Season;
use app\models\Verein;
use app\models\vereinsmeldung\vereinskontakte\VereinsmeldungKontakte;
use app\models\vereinsmeldung\teams\VereinsmeldungTeams;

/**
 * This is the model class for table "vereinsmeldung".
 *
 * @property int $id
 * @property int $season_id
 * @property int $vereins_id
 * @property string|null $created_at
 * @property string|null $status
 * @property VereinsmeldungKontakte[] $vereinsmeldungKontakte
 * @property VereinsmeldungTeams[] $vereinsmeldungTeams
 *
 * @property Season $season
 * @property Verein $verein
 */
class Vereinsmeldung extends \yii\db\ActiveRecord
{
    public static $STATUS_OPEN      = "offen";
    public static $STATUS_STARTED   = "begonnen";
    public static $STATUS_FINISHED  = "fertig";
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vereinsmeldung';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['season_id', 'vereins_id'], 'required'],
            [['season_id', 'vereins_id'], 'integer'],
            [['created_at'], 'safe'],
            [['status'], 'string', 'max' => 45],
            [['season_id'], 'exist', 'skipOnError' => true, 'targetClass' => Season::className(), 'targetAttribute' => ['season_id' => 'id']],
            [['vereins_id'], 'exist', 'skipOnError' => true, 'targetClass' => Verein::className(), 'targetAttribute' => ['vereins_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'season_id' => 'Season ID',
            'vereins_id' => 'Vereins ID',
            'created_at' => 'Created At',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[Season]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSeason()
    {
        return $this->hasOne(Season::className(), ['id' => 'season_id']);
    }

    /**
     * Gets query for [[Verein]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVerein()
    {
        return $this->hasOne(Verein::className(), ['id' => 'vereins_id']);
    }

    /**
     * Gets query for [[VereinsmeldungKontaktes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVereinsmeldungKontakte()
    {
        return $this->hasOne(VereinsmeldungKontakte::className(), ['vereinsmeldung_id' => 'id']);
    }

    /**
     * Gets query for [[VereinsmeldungTeams]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVereinsmeldungTeams()
    {
        return $this->hasOne(VereinsmeldungTeams::className(), ['vereinsmeldung_id' => 'id']);
    }
    
    
    /**
     * Laedt Vereinsmeldung des aktuellen Users zur aktiven Season.
     * @param Verein $verein Verein
     * @param Season $season Season [optional] Default ist aktive Saison
     * @return \yii\db\ActiveQuery
     */
    public static function getVereinsmeldungOfVerein($verein, $season = false)
    {
        $season = Season::getSeason($season);
        $vereinsmeldung = Vereinsmeldung::find()->where(['season_id'=>$season->id,'vereins_id'=>$verein->id])->one();
        
        return $vereinsmeldung;
    }
    
    /**
     * Prüft, ob die Vereinsmeldung bereits von einem Verein gepflegt wurde
     * @param type $season
     */
    public static function isStarted($season){
        $items =  Vereinsmeldung::find()->where("status != 'offen'")->all();
        if( $items && count($items) > 0)
            return true;
        return false;
    }


    public static function create($season, $verein){
        $vm = new Vereinsmeldung();
        $vm->season_id  = $season->id;
        $vm->vereins_id = $verein->id;
        $vm->status     = Vereinsmeldung::$STATUS_OPEN;
        if($vm->save()){
            return true;
        }
        return false;
    }    

    /**
     * Löscht alle Vereinsmeldungen zu einer Saison
     * @param Season $season
     * @return boolean
     */
    public static function deleteBySeason($season){
        $items = Vereinsmeldung::find()->where(['season_id'=>$season->id])->all();
        foreach($items as $item){
            if(!$item->delete())
                return false;
        }
        return true;
    }
    
    /**
     * Setzt und speichert den Status
     * @param String|boolean $status Einer der Werte aus static [optional/default=OPEN]
     * @return boolean
     */
    public function setStatus($status = false){
        if(!$this->status)
            $this->status = Vereinsmeldung::$STATUS_OPEN;
        else
            $this->status = $status;
        
        if(!$this->save())
            return false;
        return true;
    }    
    
    
}
