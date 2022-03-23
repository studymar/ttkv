<?php

namespace app\models\Vereinsmeldung;

use Yii;
use yii\db\Expression;

/**
 * This is the model class for table "season".
 *
 * @property int $id
 * @property string $name
 * @property string|null $created_at
 * @property int|null $active
 *
 * @property SeasonHasVereinsmeldemodul[] $seasonHasVereinsmeldemodule
 * @property Vereinsmeldemodul[] $vereinsmeldemodule
 * @property Vereinsmeldung[] $vereinsmeldungen
 */
class Season extends \yii\db\ActiveRecord
{
    public $checked_ids;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'season';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['created_at'], 'safe'],
            [['active'], 'integer'],
            [['name'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'created_at' => 'Created At',
            'active' => 'Active',
        ];
    }

    /**
     * Gets query for [[SeasonHasVereinsmeldemodule]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSeasonHasVereinsmeldemodule()
    {
        return $this->hasMany(SeasonHasVereinsmeldemodul::className(), ['season_id' => 'id']);
    }

    /**
     * Gets query for [[Vereinsmeldemodule]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVereinsmeldemodule()
    {
        return $this->hasMany(Vereinsmeldemodul::className(), ['id' => 'vereinsmeldemodul_id'])->viaTable('season_has_vereinsmeldemodul', ['season_id' => 'id']);
    }

    /**
     * Gets query for [[Vereinsmeldungen]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVereinsmeldungen()
    {
        return $this->hasMany(Vereinsmeldung::className(), ['season_id' => 'id']);
    }
    
    
    /**
     * Laedt eine Saison
     * @param int $season [optional] ID Default=aktuell
     */
    public static function getSeason($season = false){
        if($season)
            $filter = ['id'=>$season];
        else 
            $filter = ['active'=>'1'];
        return self::find()->where($filter)->one();
    }

    /**
     * Laedt ID der neusten Saison
     * @return int
     */
    public static function getNewestSeasonId(){
        return self::find()->max('id');
    }
    
    /**
     * Laedt eine Saison
     * @param string $season [optional] Name Default=aktuell
     */
    public static function getSeasonByName($season = false){
        if($season)
            $filter = ['name'=>$season];
        else 
            $filter = ['active'=>'1'];
        return self::find()->where($filter)->one();
    }
    
    /**
     * Löscht bisherige Module und speichert die Neuen,Übergebenen
     * @param array $modules ids der Vereinsmeldemodules-Objekte
     * @return boolean
     */
    public function saveModules($modules = array()){
        //alte Zuordnung loeschen
        \app\models\vereinsmeldung\SeasonHasVereinsmeldemodul::deleteAll(['season_id' => $this->id]);
        
        //sicherstellen, dass parameter ein array ist (Beispiel: keine Rechte = null)
        if(!is_array($modules)) 
            $modules = array();
        //neue zuordnung eintragen
        $count = 1;
        foreach($modules as $moduleId){
            $new = new \app\models\vereinsmeldung\SeasonHasVereinsmeldemodul();
            $new->vereinsmeldemodul_id = $moduleId;
            $new->season_id  = $this->id;
            $new->sort       = $count++;
            if(!$new->save()){
                Yii::error(json_encode($new->getErrors())." beim Speichern der Module");
                return false;
            }
        };
        return true;
    }
    
    
    /**
     * Löscht Season und Zuordnungen
     * @return boolean
     */
    public function deleteSeason(){
        if(!\app\models\vereinsmeldung\Vereinsmeldung::deleteBySeason($this))
            return false;
        foreach($this->seasonHasVereinsmeldemodule as $item){
            if(!$item->delete())
                return false;
        }
        return $this->delete();
        
    }
    
    public function isDeletable(){
        return !Vereinsmeldung::isStarted($this);
    }
    
    public function create(){
        if($this->save()){
            $vereine = \app\models\Verein::find()->where('deleted is null')->all();
            foreach($vereine as $item){
                \app\models\vereinsmeldung\Vereinsmeldung::create($this, $item);
            }
            return true;
        }
        return false;
    }    
}
