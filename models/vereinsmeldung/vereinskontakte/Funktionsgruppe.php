<?php

namespace app\models\vereinsmeldung\vereinskontakte;

use Yii;

/**
 * This is the model class for table "funktionsgruppe".
 *
 * @property int $id
 * @property string|null $name
 *
 * @property Vereinsrolle[] $vereinsrolles
 */
class Funktionsgruppe extends \yii\db\ActiveRecord
{
    public static $VEREINSVORSTAND_ID        = 1;
    public static $KREISVORSTAND_ID          = 2;
    public static $KREISKASSENPREUFER_ID     = 3;
    public static $KREISJUGENDAUSSCHUSS_ID   = 4;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'funktionsgruppe';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
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
        ];
    }

    /**
     * Gets query for [[Vereinsrolles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVereinsrolles()
    {
        return $this->hasMany(Vereinsrolle::className(), ['funktionsgruppe_id' => 'id']);
    }
}
