<?php
namespace app\models\forms;

use Yii;
use yii\base\Model;
use app\models\forms\TeamEditForm;
use app\models\vereinsmeldung\teams\VereinsmeldungTeams;
use app\models\vereinsmeldung\teams\Liga;
use app\models\vereinsmeldung\teams\Altersklasse;
use app\models\vereinsmeldung\teams\Altersbereich;

class TeamEditForm extends Model {
   public $id;
   public $liga_id;
   public $regional;
   public $altersbereich_id;
   public $altersklasse_id;
   public $heimspieltage;
   public $weeks;
   public $pokalteilnahme;
   public $created_at;
   
 
   public function __construct() {
      
   }

         
   public function rules() {
      return array(
          
            [['altersbereich_id', 'altersklasse_id', 'liga_id','heimspieltage'], 'required','message'=>'{attribute} darf nicht leer sein'],
            [['altersbereich_id', 'altersklasse_id', 'liga_id', 'pokalteilnahme','weeks'], 'integer'],
            [['created_at'], 'safe'],
            [['heimspieltage','regional'], 'string', 'max' => 255],
            [['id'], 'safe'],
            [['altersbereich_id'], 'exist', 'skipOnError' => true, 'targetClass' => Altersbereich::className(), 'targetAttribute' => ['altersbereich_id' => 'id']],
            [['altersklasse_id'], 'exist', 'skipOnError' => true, 'targetClass' => Altersklasse::className(), 'targetAttribute' => ['altersklasse_id' => 'id']],
            [['liga_id'], 'exist', 'skipOnError' => true, 'targetClass' => Liga::className(), 'targetAttribute' => ['liga_id' => 'id']],
          
       );
   }

   public function validateHeimspieltage(){
       return true;
   }
    
   public function attributeLabels(){
      return array(
         'id' => 'Id',
         'altersbereich_id' => 'Altersbereich',
         'altersklasse_id' => 'Altersklasse',
         'liga_id' => 'Liga',
      );
   } 

    public function mapFromTeam($item, $altersbereich)
    {
        $this->id               = $item->id;
        $this->liga_id          = $item->liga_id;
        $this->altersbereich_id = $altersbereich->id;
        $this->altersklasse_id  = $item->altersklasse_id;
        $this->heimspieltage    = $item->heimspieltage;
        $this->weeks            = $item->weeks;
        $this->pokalteilnahme   = $item->pokalteilnahme;
        $this->created_at       = $item->created_at;
        
    }   
    public function mapToTeam($item)
    {
        $item->id                  = $this->id;
        $item->liga_id             = $this->liga_id;
        $item->altersklasse_id     = $this->altersklasse_id;
        $item->heimspieltage       = $this->heimspieltage;
        $item->weeks               = $this->weeks;
        $item->pokalteilnahme      = $this->pokalteilnahme;
        $item->created_at          = $this->created_at;
        return $item;
    }   
    
   
}