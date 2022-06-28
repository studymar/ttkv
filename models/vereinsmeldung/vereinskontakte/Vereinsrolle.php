<?php

namespace app\models\vereinsmeldung\vereinskontakte;

use Yii;
use app\models\kreiskontakte\KreisrolleHasFunktionsgruppe;
use app\models\kreiskontakte\Kreiskontakt;

/**
 * This is the model class for table "vereinsrolle".
 *
 * @property int $id
 * @property int $funktionsgruppe_id
 * @property string|null $name
 * @property string|null $shortname
 *
 * @property Funktionsgruppe $funktionsgruppe
 * @property Vereinskontakt[] $vereinskontakte
 * @property Vereinskontakt[] $kreiskontakte
 * @property KreisrolleHasFunktionsgruppe[] $kreisrolleHasFunktionsgruppen
 * @property Funktionsgruppe[] $mitgliedInKreisausschuessen
 */
class Vereinsrolle extends \yii\db\ActiveRecord
{
    public static $ID_ABTEILUNGSLEITER = 1;
    
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vereinsrolle';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'funktionsgruppe_id'], 'required'],
            [['id', 'funktionsgruppe_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['shortname'], 'string', 'max' => 45],
            [['id'], 'unique'],
            [['funktionsgruppe_id'], 'exist', 'skipOnError' => true, 'targetClass' => Funktionsgruppe::className(), 'targetAttribute' => ['funktionsgruppe_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'funktionsgruppe_id' => 'Funktionsgruppe ID',
            'name' => 'Name',
            'shortname' => 'Shortname',
        ];
    }

    /**
     * Gets query for [[Funktionsgruppe]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFunktionsgruppe()
    {
        return $this->hasOne(Funktionsgruppe::className(), ['id' => 'funktionsgruppe_id']);
    }

    /**
     * Gets query for [[Vereinskontaktes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVereinskontakte()
    {
        return $this->hasMany(Vereinskontakt::className(), ['vereinsrolle_id' => 'id']);
    }

    /**
     * Gets query for [[Kreiskontaktes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKreiskontakte()
    {
        return $this->hasMany(Kreiskontakt::className(), ['vereinsrolle_id' => 'id']);
    }
    
    
    /**
     * Gets query for [[Funktionsgruppes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMitgliedInKreisausschuessen()
    {
        return $this->hasMany(Funktionsgruppe::className(), ['id' => 'funktionsgruppe_id'])->via('kreisrolleHasFunktionsgruppen');
    }    

    /**
     * Gets query for [[KreisrolleHasFunktionsgruppes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKreisrolleHasFunktionsgruppen()
    {
        return $this->hasMany(KreisrolleHasFunktionsgruppe::className(), ['vereinsrolle_id' => 'id']);
    }
    
    /**
     * Gibt alle Vereinsrollen einer oder mehrerer Funktionsgruppen zurück
     * @param int $funktionsgruppen_ids
     */
    public static function getVereinsrollen(array $funktionsgruppen_ids = []){
        return Vereinsrolle::find()->where(['in', 'funktionsgruppe_id', $funktionsgruppen_ids]);
    }
    
}
