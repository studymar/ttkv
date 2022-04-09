<?php

namespace app\models\vereinsmeldung\vereinskontakte;

use Yii;

/**
 * This is the model class for table "vereinskontakte".
 *
 * @property int $id
 * @property int $vereinsmeldung_kontakte_id
 * @property int $vereinsrolle_id
 * @property int $person_id
 * @property string|null $created_at
 *
 * @property Person $person
 * @property VereinsmeldungKontakte $vereinsmeldungKontakte
 * @property Vereinsrolle $vereinsrolle
 */
class Vereinskontakt extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vereinskontakt';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'vereinsmeldung_kontakte_id', 'vereinsrolle_id', 'person_id'], 'required'],
            [['id', 'vereinsmeldung_kontakte_id', 'vereinsrolle_id', 'person_id'], 'integer'],
            [['created_at'], 'safe'],
            [['id'], 'unique'],
            [['person_id'], 'exist', 'skipOnError' => true, 'targetClass' => Person::className(), 'targetAttribute' => ['person_id' => 'id']],
            [['vereinsmeldung_kontakte_id'], 'exist', 'skipOnError' => true, 'targetClass' => VereinsmeldungKontakte::className(), 'targetAttribute' => ['vereinsmeldung_kontakte_id' => 'id']],
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
            'vereinsmeldung_kontakte_id' => 'Vereinsmeldung Kontakte ID',
            'vereinsrolle_id' => 'Vereinsrolle ID',
            'person_id' => 'Person ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Person]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPerson()
    {
        return $this->hasOne(Person::className(), ['id' => 'person_id']);
    }

    /**
     * Gets query for [[VereinsmeldungKontakte]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVereinsmeldungKontakte()
    {
        return $this->hasOne(VereinsmeldungKontakte::className(), ['id' => 'vereinsmeldung_kontakte_id']);
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
     * @param Person $person
     * @param VereinsmeldungKontakte $vereinsmeldungKontakte
     * @param array $vereinsrollen_ids
     */
    public static function saveVereinsrollen(Person $person, VereinsmeldungKontakte $vereinsmeldungKontakte, array $vereinsrollen_ids){
        Vereinskontakt::deleteAll(['person_id' => $person->id]);
        foreach($vereinsrollen_ids as $item){
            $newItem = new Vereinskontakt();
            $newItem->id                        = 0;
            $newItem->vereinsmeldung_kontakte_id= $vereinsmeldungKontakte->id;
            $newItem->vereinsrolle_id           = $item;
            $newItem->person_id                 = $person->id;
            $newItem->created_at                = new \yii\db\Expression("NOW()");
            if(!$newItem->save()){
                throw new Exception($newItem->getErrors());
            }
        }
        $vereinsmeldungKontakte->checkIsDone();
        return true;
    }
}
