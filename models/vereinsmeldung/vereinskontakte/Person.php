<?php

namespace app\models\vereinsmeldung\vereinskontakte;

use Yii;

/**
 * This is the model class for table "person".
 *
 * @property int $id
 * @property int $vereinsmeldung_kontakte_id
 * @property string|null $firstname
 * @property string|null $lastname
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $street
 * @property string|null $zip
 * @property string|null $city
 * @property string|null $created_at
 *
 * @property VereinsmeldungKontakte $vereinsmeldungKontakte
 * @property Vereinskontakt[] $vereinskontakte
 */
class Person extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'person';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id','vereinsmeldung_kontakte_id'], 'required'],
            [['id','vereinsmeldung_kontakte_id'], 'integer'],
            [['created_at'], 'safe'],
            [['firstname', 'phone'], 'string', 'max' => 45],
            [['lastname', 'street', 'city'], 'string', 'max' => 255],
            [['email'], 'string', 'max' => 120],
            [['zip'], 'string', 'max' => 10],
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
            'firstname' => 'Firstname',
            'lastname' => 'Lastname',
            'email' => 'Email',
            'phone' => 'Telefon',
            'street' => 'Street',
            'zip' => 'Zip',
            'city' => 'City',
            'created_at' => 'Created At',
        ];
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
     * Gets query for [[Vereinskontakte]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVereinskontakte()
    {
        return $this->hasMany(Vereinskontakt::className(), ['person_id' => 'id']);
    }
    
    /**
     * Löscht Person
     * @return boolean
     */
    public function deletePerson(){
        if(count($this->vereinskontakte) > 0)
            throw new \yii\base\Exception('Fehler: Person nicht löschbar, weil noch Rolle zugeordnet.');
        return $this->delete();
    }
    
    public function isDeletable(){
        return !count($this->vereinskontakte);
    }
    
    public function create(VereinsmeldungKontakte $vereinsmeldungKontakte){
        $this->id = 0;
        $this->vereinsmeldung_kontakte_id = $vereinsmeldungKontakte->id;
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
