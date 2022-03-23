<?php

namespace app\models\vereinsmeldung\teams;

use Yii;

/**
 * This is the model class for table "altersklasse".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $sort
 * @property int $altersbereich_id
 *
 * @property Altersbereich $altersbereich
 */
class Altersklasse extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'altersklasse';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'altersbereich_id'], 'required'],
            [['id', 'sort', 'altersbereich_id'], 'integer'],
            [['name'], 'string', 'max' => 45],
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
            'sort' => 'Sort',
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
}
