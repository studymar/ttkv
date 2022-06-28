<?php

namespace app\models\kreiskontakte;

use Yii;
use app\models\vereinsmeldung\vereinskontakte\Vereinsrolle;
use app\models\vereinsmeldung\vereinskontakte\Funktionsgruppe;

/**
 * This is the model class for table "kreisrolle_has_funktionsgruppe".
 *
 * @property int $vereinsrolle_id
 * @property int $funktionsgruppe_id
 * @property int|null $sort
 *
 * @property Funktionsgruppe $funktionsgruppe
 * @property Vereinsrolle $vereinsrolle
 */
class KreisrolleHasFunktionsgruppe extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kreisrolle_has_funktionsgruppe';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['vereinsrolle_id', 'funktionsgruppe_id'], 'required'],
            [['vereinsrolle_id', 'funktionsgruppe_id', 'sort'], 'integer'],
            [['vereinsrolle_id', 'funktionsgruppe_id'], 'unique', 'targetAttribute' => ['vereinsrolle_id', 'funktionsgruppe_id']],
            [['funktionsgruppe_id'], 'exist', 'skipOnError' => true, 'targetClass' => Funktionsgruppe::className(), 'targetAttribute' => ['funktionsgruppe_id' => 'id']],
            [['vereinsrolle_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vereinsrolle::className(), 'targetAttribute' => ['vereinsrolle_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'vereinsrolle_id' => 'Vereinsrolle ID',
            'funktionsgruppe_id' => 'Funktionsgruppe ID',
            'sort' => 'Sort',
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
     * Gets query for [[Vereinsrolle]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVereinsrolle()
    {
        return $this->hasOne(Vereinsrolle::className(), ['id' => 'vereinsrolle_id']);
    }
    
     /**
     * Speichert die einzelnen Funktionsgruppen zum Kontakt
     * @param Kreisperson $person
     * @param array $funktionsgruppen_ids
     */
    public static function saveFunktionsgruppen(Vereinsrolle $vereinsrolle, array $funktionsgruppen_ids){
        KreisrolleHasFunktionsgruppe::deleteAll(['vereinsrolle_id' => $vereinsrolle->id]);
        $x = 1;
        foreach($funktionsgruppen_ids as $item){
            $newItem = new KreisrolleHasFunktionsgruppe();
            $newItem->vereinsrolle_id           = $vereinsrolle->id;
            $newItem->funktionsgruppe_id        = $item;
            $newItem->sort                      = $x++;
            if(!$newItem->save()){
                throw new Exception(\yii\helpers\Json::encode($newItem->getErrors()));
            }
        }
        return true;
    }
    
    
}
