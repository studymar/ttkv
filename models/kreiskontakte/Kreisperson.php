<?php

namespace app\models\kreiskontakte;

use Yii;

/**
 * This is the model class for table "kreisperson".
 *
 * @property int $id
 * @property string|null $firstname
 * @property string|null $lastname
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $street
 * @property string|null $zip
 * @property string|null $city
 * @property string|null $created_at
 *
 * @property Kreiskontakt[] $kreiskontakte
 */
class Kreisperson extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kreisperson';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at'], 'safe'],
            [['firstname', 'phone'], 'string', 'max' => 45],
            [['lastname', 'street', 'city'], 'string', 'max' => 255],
            [['email'], 'string', 'max' => 120],
            [['zip'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'firstname' => 'Firstname',
            'lastname' => 'Lastname',
            'email' => 'Email',
            'phone' => 'Phone',
            'street' => 'Street',
            'zip' => 'Zip',
            'city' => 'City',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Kreiskontakts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKreiskontakte()
    {
        return $this->hasMany(Kreiskontakt::className(), ['person_id' => 'id']);
    }
    
    /**
     * Löscht Person
     * @return boolean
     */
    public function deletePerson(){
        if(count($this->kreiskontakte) > 0)
            throw new \yii\base\Exception('Fehler: Person nicht löschbar, weil noch Rolle zugeordnet.');
        return $this->delete();
    }
    
    public function isDeletable(){
        return !count($this->kreiskontakte);
    }
    
    
    public function create(){
        $this->id = 0;
        $this->created_at = new \yii\db\Expression("NOW()");
        if($this->save()){
            return true;
        }
        Yii::debug($this->getErrors());
        return false;
    }

    public function getAddress(){
        $ret = "";
        if($this->street )
            $ret.= ", ";
        $ret.= $this->street;
        if($this->city || $this->city)
            $ret.= ", ";
        $ret.= $this->zip;
        if($this->city || $this->city)
            $ret.= " ";
        $ret.= $this->city;
        return $ret;
    }
    
    
}
