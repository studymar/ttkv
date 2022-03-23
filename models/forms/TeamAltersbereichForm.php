<?php
namespace app\models\forms;

use Yii;
use yii\base\Model;
use app\models\forms\TeamEditForm;
use app\models\vereinsmeldung\teams\VereinsmeldungTeams;
use app\models\vereinsmeldung\teams\Liga;
use app\models\vereinsmeldung\teams\Altersklasse;
use app\models\vereinsmeldung\teams\Altersbereich;

class TeamAltersbereichForm extends Model {
   public $altersbereich_id;
   
 
   public function __construct() {
      
   }

         
   public function rules() {
      return array(
          
            [['altersbereich_id'], 'required','message'=>'{attribute} darf nicht leer sein'],
            [['altersbereich_id'], 'integer'],
       );
   }

   public function validateHeimspieltage(){
       return true;
   }
    
   public function attributeLabels(){
      return array(
         'altersbereich_id' => 'Altersbereich',
      );
   } 

   
}