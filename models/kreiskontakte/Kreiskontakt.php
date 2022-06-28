<?php

namespace app\models\kreiskontakte;

use Yii;
use app\models\kreiskontakte\Kreiskontakt;
use app\models\kreiskontakte\Kreisperson;
use app\models\vereinsmeldung\vereinskontakte\Vereinsrolle;
use yii\base\Exception;

/**
 * This is the model class for table "kreiskontakt".
 *
 * @property int $id
 * @property int $person_id
 * @property int $vereinsrolle_id
 * @property string|null $created_at
 *
 * @property Person $person
 * @property Vereinsrolle $vereinsrolle
 */
class Kreiskontakt extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kreiskontakt';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'person_id', 'vereinsrolle_id'], 'required'],
            [['id', 'person_id', 'vereinsrolle_id'], 'integer'],
            [['created_at'], 'safe'],
            [['id'], 'unique'],
            [['person_id'], 'exist', 'skipOnError' => true, 'targetClass' => Kreisperson::className(), 'targetAttribute' => ['person_id' => 'id']],
            [['vereinsrolle_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vereinsrolle::className(), 'targetAttribute' => ['vereinsrolle_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'person_id' => 'Person ID',
            'vereinsrolle_id' => 'Vereinsrolle ID',
            'created_at' => 'Created At',
            'sort' => 'Sort',
        ];
    }

    /**
     * Gets query for [[Funktionsgruppes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFunktionsgruppes()
    {
        return $this->hasMany(Funktionsgruppe::className(), ['id' => 'funktionsgruppe_id'])->via('kreiskontaktHasFunktionsgruppes');
    }


    /**
     * Gets query for [[Person]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPerson()
    {
        return $this->hasOne(Kreisperson::className(), ['id' => 'person_id']);
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
     * Speichert die einzelnen Vereinsrollen zum Kontakt
     * @param Kreisperson $person
     * @param array $vereinsrollen_ids
     */
    public static function saveVereinsrollen(Kreisperson $person, array $vereinsrollen_ids){
        Kreiskontakt::deleteAll(['person_id' => $person->id]);
        foreach($vereinsrollen_ids as $item){
            $newItem = new Kreiskontakt();
            $newItem->id                        = 0;
            $newItem->vereinsrolle_id           = $item;
            $newItem->person_id                 = $person->id;
            $newItem->created_at                = new \yii\db\Expression("NOW()");
            if(!$newItem->save()){
                throw new Exception(\yii\helpers\Json::encode($newItem->getErrors()));
            }
        }
        return true;
    }
    
    
}
