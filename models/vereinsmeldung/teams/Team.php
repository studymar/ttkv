<?php

namespace app\models\vereinsmeldung\teams;

use Yii;

/**
 * This is the model class for table "team".
 *
 * @property int $id
 * @property int $vereinsmeldung_teams_id
 * @property int $altersklasse_id
 * @property int $number
 * @property int $liga_id
 * @property int $weeks
 * @property string|null $regional
 * @property string|null $heimspieltage
 * @property int|null $pokalteilnahme
 * @property string|null $created_at
 *
 * @property Altersklasse $altersklasse
 * @property Liga $liga
 * @property VereinsmeldungTeams $vereinsmeldungTeams
 */
class Team extends \yii\db\ActiveRecord
{
    public static $WEEKS_EGAL_ID    = 0;
    public static $WEEKS_EGAL       = 'egal';
    public static $WEEKS_UNGERADE_ID= 1;
    public static $WEEKS_UNGERADE   = 'ungerade Wochen';
    public static $WEEKS_GERADE_ID  = 2;
    public static $WEEKS_GERADE     = 'gerade Wochen';
    
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'team';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'season_id', 'vereinsmeldung_teams_id', 'altersklasse_id', 'liga_id'], 'required'],
            [['id', 'season_id', 'vereinsmeldung_teams_id', 'altersklasse_id', 'number', 'liga_id', 'pokalteilnahme', 'weeks'], 'integer'],
            [['created_at'], 'safe'],
            [['heimspieltage','regional'], 'string', 'max' => 255],
            [['id'], 'unique'],
            [['altersklasse_id'], 'exist', 'skipOnError' => true, 'targetClass' => Altersklasse::className(), 'targetAttribute' => ['altersklasse_id' => 'id']],
            [['liga_id'], 'exist', 'skipOnError' => true, 'targetClass' => Liga::className(), 'targetAttribute' => ['liga_id' => 'id']],
            [['vereinsmeldung_teams_id'], 'exist', 'skipOnError' => true, 'targetClass' => VereinsmeldungTeams::className(), 'targetAttribute' => ['vereinsmeldung_teams_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'vereinsmeldung_teams_id' => 'Vereinsmeldung Teams ID',
            'altersklasse_id' => 'Altersklasse',
            'liga_id' => 'Liga',
            'Regional' => 'Regional',
            'heimspieltage' => 'Heimspieltage',
            'pokalteilnahme' => 'Pokalteilnahme',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Altersklasse]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAltersklasse()
    {
        return $this->hasOne(Altersklasse::className(), ['id' => 'altersklasse_id']);
    }

    /**
     * Gets query for [[Liga]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLiga()
    {
        return $this->hasOne(Liga::className(), ['id' => 'liga_id']);
    }

    /**
     * Gets query for [[VereinsmeldungTeams]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVereinsmeldungTeams()
    {
        return $this->hasOne(VereinsmeldungTeams::className(), ['id' => 'vereinsmeldung_teams_id']);
    }
    
    public static function getWeeksOptions(){
        return [
          self::$WEEKS_EGAL_ID => self::$WEEKS_EGAL,
          self::$WEEKS_UNGERADE_ID => self::$WEEKS_UNGERADE,
          self::$WEEKS_GERADE_ID => self::$WEEKS_GERADE,
        ];
    }
    
    public static function countTeamsOfVereinInAltersklasse($vereinsmeldungTeams,$altersklasse){
        return Team::find()->where(['altersklasse_id'=>$altersklasse->id, 'vereinsmeldung_teams_id'=>$vereinsmeldungTeams->id])->count();
    }
    
    public function create(VereinsmeldungTeams $vereinsmeldungTeams){
        $this->id           = 0;
        $this->season_id    = $vereinsmeldungTeams->vereinsmeldung->season_id;
        $this->vereinsmeldung_teams_id = $vereinsmeldungTeams->id;
        $this->number       = Team::countTeamsOfVereinInAltersklasse($this->vereinsmeldungTeams, $this->altersklasse)+1;
        $this->created_at = new \yii\db\Expression("NOW()");
        if($this->save()){
            $vereinsmeldungTeams->checkIsDone();
            return true;
        }
        Yii::debug($this->getErrors());
        return false;
    }
    
    public function getWeeksName(){
        switch ($this->weeks) {
            case self::$WEEKS_EGAL_ID:
                return self::$WEEKS_EGAL;
                break;
            case self::$WEEKS_UNGERADE_ID:
                return self::$WEEKS_UNGERADE;
                break;
            case self::$WEEKS_GERADE_ID:
                return self::$WEEKS_GERADE;
                break;
        }
    }
    
    
}
