<?php

namespace app\models\vereinsmeldung\teams;

use Yii;
use app\models\vereinsmeldung\teams\Ligazusammenstellung;

/**
 * This is the model class for table "altersbereich".
 *
 * @property int $id
 * @property string|null $name
 * @property int $askweeks
 * @property int $askpokal
 *
 * @property Altersklasse[] $altersklasses
 * @property Ligazusammenstellung[] $ligazusammenstellungs
 */
class Altersbereich extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'altersbereich';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id','askweeks','askpokal'], 'integer'],
            [['name'], 'string', 'max' => 45],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[Altersklasses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAltersklasses()
    {
        return $this->hasMany(Altersklasse::className(), ['altersbereich_id' => 'id']);
    }

    /**
     * Gets query for [[Ligazusammenstellungs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLigazusammenstellungs()
    {
        return $this->hasMany(Ligazusammenstellung::className(), ['altersbereich_id' => 'id']);
    }
    
    
    /**
     * Gibt eine Liste mit Ligen und deren zugeordneten Mannschaften zurück
     * @param int $season_id
     * @param int $altersbereich_id
     * @return Team[] key=liganame / value=Team
     */
    public static function getLigeneinteilungOfAltersbereich($season, int $altersbereich_id){
        $ligazusammenstellung   = Ligazusammenstellung::find()->where(['altersbereich_id'=>$altersbereich_id])->one();
        $ligen                  = $ligazusammenstellung->ligen;
        foreach($ligen as $liga){
           $teams[$liga->name] = Team::find()->where(['liga_id'=>$liga->id, 'season_id'=>$season->id])->all();
        }
        
        return $teams;
    }
    
}
