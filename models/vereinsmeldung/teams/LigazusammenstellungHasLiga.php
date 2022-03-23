<?php

namespace app\models\vereinsmeldung\teams;

use Yii;

/**
 * This is the model class for table "ligazusammenstellung_has_liga".
 *
 * @property int $ligazusammenstellung_id
 * @property int $liga_id
 * @property string|null $created_at
 *
 * @property Liga $liga
 * @property Ligazusammenstellung $ligazusammenstellung
 */
class LigazusammenstellungHasLiga extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ligazusammenstellung_has_liga';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ligazusammenstellung_id', 'liga_id'], 'required'],
            [['ligazusammenstellung_id', 'liga_id'], 'integer'],
            [['created_at'], 'safe'],
            [['ligazusammenstellung_id', 'liga_id'], 'unique', 'targetAttribute' => ['ligazusammenstellung_id', 'liga_id']],
            [['liga_id'], 'exist', 'skipOnError' => true, 'targetClass' => Liga::className(), 'targetAttribute' => ['liga_id' => 'id']],
            [['ligazusammenstellung_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ligazusammenstellung::className(), 'targetAttribute' => ['ligazusammenstellung_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ligazusammenstellung_id' => 'Ligazusammenstellung ID',
            'liga_id' => 'Liga ID',
            'created_at' => 'Created At',
        ];
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
     * Gets query for [[Ligazusammenstellung]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLigazusammenstellung()
    {
        return $this->hasOne(Ligazusammenstellung::className(), ['id' => 'ligazusammenstellung_id']);
    }
}
