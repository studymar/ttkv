<?php

namespace app\models\vereinsmeldung\vereinskontakte;

use Yii;
use app\models\kreiskontakte\KreisrolleHasFunktionsgruppe;

/**
 * This is the model class for table "funktionsgruppe".
 *
 * @property int $id
 * @property string|null $name
 *
 * @property Vereinsrolle[] $vereinsrollen
 * @property KreisrolleHasFunktionsgruppen[] $kreisrolleHasFunktionsgruppen
 * @property Vereinsrolle[] $vereinsrollenImAusschuss
 * 
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
     * Gets query for [[KreisrolleHasFunktionsgruppen]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKreisrolleHasFunktionsgruppen()
    {
        return $this->hasMany(KreisrolleHasFunktionsgruppe::className(), ['funktionsgruppe_id' => 'id']);
    }

    /**
     * Gets query for [[Ausschussrollen]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVereinsrollenImAusschuss()
    {
        return $this->hasMany(Vereinsrolle::className(), ['id' => 'vereinsrolle_id'])->via('kreisrolleHasFunktionsgruppen');
    }
    
    
    /**
     * Gets query for [[Vereinsrollen]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVereinsrollen()
    {
        return $this->hasMany(Vereinsrolle::className(), ['funktionsgruppe_id' => 'id']);
    }
    
    /**
     * Alle Gruppen/Ausschusse des Kreises
     */
    public static function getKreisgruppen()
    {
        //alle außer Vereinsvorstand
        return Funktionsgruppe::find()->where('id != 1')->all();
    }    
    
}
