<?php

namespace app\models\vereinsmeldung;

use Yii;

/**
 * This is the model class for table "season_has_vereinsmeldemodul".
 *
 * @property int $season_id
 * @property int $vereinsmeldemodul_id
 * @property int $sort
 *
 * @property Season $season
 * @property Vereinsmeldemodul $vereinsmeldemodul
 */
class SeasonHasVereinsmeldemodul extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'season_has_vereinsmeldemodul';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['season_id', 'vereinsmeldemodul_id'], 'required'],
            [['season_id', 'vereinsmeldemodul_id','sort'], 'integer'],
            [['season_id', 'vereinsmeldemodul_id'], 'unique', 'targetAttribute' => ['season_id', 'vereinsmeldemodul_id']],
            [['season_id'], 'exist', 'skipOnError' => true, 'targetClass' => Season::className(), 'targetAttribute' => ['season_id' => 'id']],
            [['vereinsmeldemodul_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vereinsmeldemodul::className(), 'targetAttribute' => ['vereinsmeldemodul_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'season_id' => 'Season ID',
            'vereinsmeldemodul_id' => 'Vereinsmeldemodul ID',
            'sort' => 'Sort',
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
     * Gets query for [[Vereinsmeldemodul]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVereinsmeldemodule()
    {
        return $this->hasOne(Vereinsmeldemodul::className(), ['id' => 'vereinsmeldemodul_id'])->orderBy(['sort asc']);
    }
}
