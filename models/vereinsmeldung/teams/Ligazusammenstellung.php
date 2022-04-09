<?php

namespace app\models\vereinsmeldung\teams;

use Yii;

/**
 * This is the model class for table "ligazusammenstellung".
 *
 * @property int $id
 * @property string|null $name
 * @property int $altersbereich_id
 *
 * @property Altersbereich $altersbereich
 * @property Liga[] $ligen
 * @property LigazusammenstellungHasLiga[] $ligazusammenstellungHasLigas
 */
class Ligazusammenstellung extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ligazusammenstellung';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'altersbereich_id'], 'required'],
            [['id', 'altersbereich_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['id'], 'unique'],
            [['altersbereich_id'], 'exist', 'skipOnError' => true, 'targetClass' => Altersbereich::className(), 'targetAttribute' => ['altersbereich_id' => 'id']],
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
            'altersbereich_id' => 'Altersbereich ID',
        ];
    }

    /**
     * Gets query for [[Altersbereich]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAltersbereich()
    {
        return $this->hasOne(Altersbereich::className(), ['id' => 'altersbereich_id']);
    }

    /**
     * Gets query for [[Ligas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLigen()
    {
        return $this->hasMany(Liga::className(), ['id' => 'liga_id'])->via('ligazusammenstellungHasLigas');
    }

    /**
     * Gets query for [[LigazusammenstellungHasLigas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLigazusammenstellungHasLigas()
    {
        return $this->hasMany(LigazusammenstellungHasLiga::className(), ['ligazusammenstellung_id' => 'id']);
    }
}
