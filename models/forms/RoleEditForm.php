<?php
namespace app\models\forms;

use Yii;
use yii\base\Model;
use app\models\user\User;

class RoleEditForm extends Model {
   public $id;
   public $name;
   public $rights;
   
 
   public function __construct() {
      
   }

         
   public function rules() {
      return array(
          
         [['name'], 'required','message'=>'Bitte gib einen Namen ein.'],
         [['rights'], 'each', 'rule' => ['integer']],
         [['id'], 'integer'],
          
       );
   }
    
   public function attributeLabels(){
      return array(
         'name' => 'Bezeichnung',
      );
   } 

    public function mapFromRole($role)
    {
        $this->id      = $role->id;
        $this->name    = $role->name;
        
    }   
    public function mapToRole($role)
    {
        //$role->id      = $this->id;// id muss nicht geaendert werden
        $role->name    = $this->name;
        return $role;
    }   

    /**
     * 
     * @param Role $role
     * @return boolean
     */
    public function saveRights(\app\models\user\Role $role)
    {
        //alte löschen
        //neue hinzufügen
        $role->saveRights($this->rights);
        //$role->id      = $this->id; // id muss nicht geaendert werden
        $role->name    = $this->name;
        return $role;
    }   
   
}