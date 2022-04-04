<?php

namespace app\models\vereinsmeldung;

use Yii;
use app\models\vereinsmeldung\vereinskontakte\VereinsmeldungKontakte;

/**
 * This is the model class for table "vereinsmeldemodul".
 *
 * @property int $id
 * @property string $name
 * @property string $url
 * @property string $class_module
 *
 * @property SeasonHasVereinsmeldemodul[] $seasonHasVereinsmeldemoduls
 * @property Season[] $seasons
 */
class Vereinsmeldemodul extends \yii\db\ActiveRecord
{

    public static $ID_VEREINSMELDUNGKONTAKTE    = 1;
    public static $ID_VEREINSMELDUNGTEAMS       = 2;
    public static $ID_VEREINSMELDUNGCLICKTT     = 3;
    public static $ID_VEREINSMELDUNGPOKAL       = 4;
    public static $ID_VEREINSMELDUNGABSTIMMUNGEN= 5;
    public static $ID_VEREINSMELDUNGUMFRAGEN    = 6;

    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vereinsmeldemodul';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'url', 'class_module'], 'string', 'max' => 255],
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
            'url' => 'Url',
            'class' => 'class',
        ];
    }

    /**
     * Gets query for [[SeasonHasVereinsmeldemoduls]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSeasonHasVereinsmeldemoduls()
    {
        return $this->hasMany(SeasonHasVereinsmeldemodul::className(), ['vereinsmeldemodul_id' => 'id']);
    }

    /**
     * Gets query for [[Seasons]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSeasons()
    {
        return $this->hasMany(Season::className(), ['id' => 'season_id'])->viaTable('season_has_vereinsmeldemodul', ['vereinsmeldemodul_id' => 'id']);
    }
    
    /**
     * Prueft, ob schon erledigt
     * @param Vereinsmeldung $vereinsmeldung
     * @return boolean
     */
    public function isDone(Vereinsmeldung $vereinsmeldung){
        $classObj = $this->class_module;
        if($classObj != "" && $classObj!= null)
            return call_user_func(array($classObj,'isDone'),$vereinsmeldung);
    }
    
    /**
     * Prueft, ob ein Badge/Hinweis zur Meldung angezeigt werden kann
     * @param Vereinsmeldung $vereinsmeldung
     * @return boolean|string
     */
    public function doneError(Vereinsmeldung $vereinsmeldung){
        $classObj = $this->class_module;
        if($classObj != "" && $classObj!= null)
            return call_user_func(array($classObj,'doneError'),$vereinsmeldung);
    }
    
    
}
