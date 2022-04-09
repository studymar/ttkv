<?php

namespace app\models\vereinsmeldung\teams;

use Yii;

/**
 * This is the model class for table "liga".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $inactive
 * @property int|null $sort
 * @property int $askregional
 *
 * @property LigazusammenstellungHasLiga[] $ligazusammenstellungHasLigas
 * @property Ligazusammenstellung[] $ligazusammenstellungs
 * @property Team[] $teams
 */
class Liga extends \yii\db\ActiveRecord
{
    public static $regional = [
        1 => "Egal",
        2 => "West",
        3 => "Ost"
    ];
    
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'liga';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'sort','askregional'], 'integer'],
            [['inactive'], 'safe'],
            [['name'], 'string', 'max' => 255],
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
            'inactive' => 'Inactive',
            'sort' => 'Sort',
        ];
    }

    /**
     * Gets query for [[LigazusammenstellungHasLigas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLigazusammenstellungHasLigas()
    {
        return $this->hasMany(LigazusammenstellungHasLiga::className(), ['liga_id' => 'id']);
    }

    /**
     * Gets query for [[Ligazusammenstellungen]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLigazusammenstellungen()
    {
        return $this->hasMany(Ligazusammenstellung::className(), ['id' => 'ligazusammenstellung_id'])->via('ligazusammenstellungHasLigas');
    }

    /**
     * Gets query for [[Teams]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTeams()
    {
        return $this->hasMany(Team::className(), ['liga_id' => 'id']);
    }
}
