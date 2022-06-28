<?php
namespace app\models\forms;

use Yii;
use yii\base\Model;
use app\models\user\User;
use app\models\vereinsmeldung\vereinskontakte\Vereinskontakt;
use app\models\kreiskontakte\Kreiskontakt;
use app\models\vereinsmeldung\vereinskontakte\VereinsmeldungKontakte;
use app\models\vereinsmeldung\vereinskontakte\Person;
use app\models\kreiskontakte\Kreisperson;

class PersonEditForm extends Model {
   public $id;
   public $firstname;
   public $lastname;
   public $street;
   public $zip;
   public $city;
   public $email;
   public $phone;
   public $created_at;
   
   public $vereinsrollen_ids = [];
   public $funktionsgruppen_ids = [];
 
   public function __construct() {
      
   }

         
   public function rules() {
      return array(
          
         [['email'], 'required','message'=>'Bitte gib eine Emailadresse ein.'],
         ['email', 'email', 'message'=>'Bitte trage eine korrekte Emailadresse ein'],
         [['firstname'], 'required','message'=>'Bitte gib einen Vornamen ein.'],
         [['lastname'], 'required','message'=>'Bitte gib einen Nachnamen ein.'],
         [['street'], 'string','message'=>'Bitte gib Straße und Hnr. ein.'],
         [['zip'], 'string','message'=>'Bitte gib Straße und Hnr. ein.'],
         [['city'], 'string','message'=>'Bitte gib einen Ort ein.'],
         [['phone'], 'string','message'=>'Bitte gib eine Telefonnummer ein.'],
         [['id'], 'integer'],
         [['created_at'], 'safe'],
         [['vereinsrollen_ids'], 'each', 'rule' => ['integer']],

         [['funktionsgruppen_ids'], 'each', 'rule' => ['integer'],'on'=>'kreisperson'],
          
       );
   }

    
   public function attributeLabels(){
      return array(
         'id' => 'Id',
         'email' => 'Benutzername',
         'phone' => 'Telefon',
         'firstname' => 'Vorname',
         'lastname' => 'Nachname',
         'street' => 'Straße + Hnr',
         'zip' => 'PLZ',
         'city' => 'Ort',
         'created_at' => 'Erstellt am',
      );
   } 

    public function mapFromPerson($item)
    {
        $this->id           = $item->id;
        $this->firstname    = $item->firstname;
        $this->lastname     = $item->lastname;
        $this->street       = $item->street;
        $this->zip          = $item->zip;
        $this->city         = $item->city;
        $this->email        = $item->email;
        $this->phone        = $item->phone;
        $this->created_at   = $item->created_at;
        
        $this->vereinsrollen_ids = \yii\helpers\ArrayHelper::map($item->vereinskontakte,'id','vereinsrolle_id');
        
    }   

    public function mapFromKreisperson($item)
    {
        $this->id           = $item->id;
        $this->firstname    = $item->firstname;
        $this->lastname     = $item->lastname;
        $this->street       = $item->street;
        $this->zip          = $item->zip;
        $this->city         = $item->city;
        $this->email        = $item->email;
        $this->phone        = $item->phone;
        $this->created_at   = $item->created_at;
        
        $this->vereinsrollen_ids = \yii\helpers\ArrayHelper::map($item->kreiskontakte,'id','vereinsrolle_id');
        
    }   
    
    
    public function mapToPerson($item)
    {
        $item->id           = $this->id;
        $item->firstname    = $this->firstname;
        $item->lastname     = $this->lastname;
        $item->street       = $this->street;
        $item->zip          = $this->zip;
        $item->city         = $this->city;
        $item->email        = $this->email;
        $item->phone        = $this->phone;
        $item->created_at   = $this->created_at;
        return $item;
    }   

    /**
     * 
     * @param Person $person
     * @param VereinsmeldungKontakte $person
     * @return boolean
     */
    public function saveVereinsrollen(Person $person, VereinsmeldungKontakte $vereinsmeldungKontakte)
    {
        //alte löschen
        //neue hinzufügen
        Yii::debug(json_encode($this->vereinsrollen_ids));
        //wenn vereinsrollen_ids leerer String, ein leeres array draus machen
        if(!is_array($this->vereinsrollen_ids)){
            $this->vereinsrollen_ids = [];
        }
        return Vereinskontakt::saveVereinsrollen($person, $vereinsmeldungKontakte, $this->vereinsrollen_ids);
    }   
    
    /**
     * 
     * @param Kreisperson $person
     * @return boolean
     */
    public function saveKreisrollen(Kreisperson $person)
    {
        //alte löschen
        //neue hinzufügen
        Yii::debug(json_encode($this->vereinsrollen_ids));
        //wenn vereinsrollen_ids leerer String, ein leeres array draus machen
        if(!is_array($this->vereinsrollen_ids)){
            $this->vereinsrollen_ids = [];
        }
        if(!is_array($this->funktionsgruppen_ids)){
            $this->funktionsgruppen_ids = [];
        }
        return Kreiskontakt::saveVereinsrollen($person, $this->vereinsrollen_ids);
    }   
   
}