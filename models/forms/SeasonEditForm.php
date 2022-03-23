<?php
namespace app\models\forms;

use Yii;
use yii\base\Model;
use app\models\user\User;

class SeasonEditForm extends Model {
   public $id;
   public $name;
   public $active;
   
   public $checked_ids = [];
 
   public function __construct() {
      
   }

         
   public function rules() {
      return array(
          
         [['name'], 'required','message'=>'Bitte gib einen Namen ein.'],
         [['checked_ids'], 'each', 'rule' => ['integer']],
         [['id','active'], 'integer'],
          
       );
   }
    
   public function attributeLabels(){
      return array(
         'name' => 'Bezeichnung',
      );
   } 

    public function mapFromItem($season)
    {
        $this->id      = $season->id;
        $this->name    = $season->name;
        $this->active  = $season->active;
        
    }   
    public function mapToItem($season)
    {
        //$season->id      = $this->id;// id muss nicht geaendert werden
        $season->name    = $this->name;
        $season->active  = $this->active;
        return $season;
    }   

    /**
     * 
     * @param Season $season
     * @return boolean
     */
    public function saveModules(\app\models\Vereinsmeldung\Season $season)
    {
        //alte löschen
        //neue hinzufügen
        return $season->saveModules($this->checked_ids);

    }   
   
}