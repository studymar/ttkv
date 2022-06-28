<?php
namespace app\models\forms;

use Yii;
use yii\base\Model;

class AusschussRoleEditForm extends Model {
   public $id; //vereinsrollen_id
   public $funktionsgruppen_ids = [];
 
   public function __construct() {
      
   }

         
   public function rules() {
      return array(
          
         [['id'], 'integer'],
         [['funktionsgruppen_ids'], 'each', 'rule' => ['integer']],
          
       );
   }

    
   public function attributeLabels(){
      return array(
         'id' => 'Id',
      );
   } 

    public function mapFromVereinsrolle($item)
    {
        $this->id           = $item->id;
        $ret = [];
        foreach($item->getMitgliedInKreisausschuessen()->all() as $i){
            $ret[$i->id] = $i->id;
        }
        $this->funktionsgruppen_ids = $ret;
        //müsste hier die Relationstableee stehen?
    }   

    
    /**
     * Speichert die zugeordneten Funktionsgruppen des Kreisausschüsses
     * @return boolean
     */
    public function saveFunktionsgruppen($vereinsrolle)
    {
        //alte löschen
        //neue hinzufügen
        Yii::debug(json_encode($this->funktionsgruppen_ids));
        //wenn vereinsrollen_ids leerer String, ein leeres array draus machen
        if(!is_array($this->funktionsgruppen_ids)){
            $this->funktionsgruppen_ids = [];
        }
        return \app\models\kreiskontakte\KreisrolleHasFunktionsgruppe::saveFunktionsgruppen($vereinsrolle, $this->funktionsgruppen_ids);
    }   
   
}