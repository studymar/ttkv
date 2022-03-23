<?php

namespace app\models\user;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "role".
 *
 * @property int $id
 * @property string|null $name
 *
 * @property Right[] $rights
 * @property RoleHasRight[] $roleHasRights
 * @property User[] $users
 */
class Role extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'role';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
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
        ];
    }

    /**
     * Gets query for [[Rights]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRights()
    {
        return $this->hasMany(Right::className(), ['id' => 'right_id'])->orderBy('sort')->viaTable('role_has_right', ['role_id' => 'id']);
    }

    /**
     * Gets query for [[Rights]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRightsOfRightsgroup($rightgroup_id)
    {
        return $this->hasMany(Right::className(), ['id' => 'right_id'])->where(['rightgroup_id'=>$rightgroup_id])->orderBy('sort')->viaTable('role_has_right', ['role_id' => 'id'])->all();
    }
    
    
    /**
     * Gets query for [[RoleHasRights]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRoleHasRights()
    {
        return $this->hasMany(RoleHasRight::className(), ['role_id' => 'id']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['role_id' => 'id']);
    }
    
    
    /**
     * Gibt ein Array mit Text(Name) und Value (ID) zurück
     * @return \yii\db\ActiveQuery
     */
    public static function getAllRolesAsTextValuePair()
    {
        return Role::find()->select(['value'=>'id', 'text'=>'name'])->asArray()->all();
    }

    /**
     * @return int
     */
    public function getCountUsers()
    {   
        return $this->hasMany(User::className(), ['role_id' => 'id'])->count();
    }

    public static function countUsers($p)
    {   
        return User::find()->where(['role_id'=>$p])->count();
    }
    
    /**
     * @return boolean
     */
    public function hasRight($id)
    {
        return RoleHasRight::find()->where(['role_id' => $this->id, 'right_id'=>$id])->exists();
        //return $this->hasOne(Right::className(), ['role_id' => 'id', 'id'=>$id]);
    }

    
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created',
                'updatedAtAttribute' => false,
                'value' => new Expression('NOW()'),
            ],
        ];
    }    
    
    /**
     * 
     * @param type $name Default ist "Neue Rolle"
     * @return \app\models\Role
     */
    public static function create($name = "Neue Rolle")
    {
        $role = new Role();
        $role->name = $name;
        if( $role->save() )
            return $role;
        return null;
    }
    
    /**
     * Löscht bisherige Rechte und speichert die neuen,übergebenen Rechte
     * @param array $rights ids der Right-Objekte
     * @return boolean
     */
    public function saveRights($rights = array()){
        //alte Zuordnung loeschen
        RoleHasRight::deleteAll(['role_id' => $this->id]);
        
        //sicherstellen, dass parameter ein array ist (Beispiel: keine Rechte = null)
        if(!is_array($rights)) 
            $rights = array();
        //neue zuordnung eintragen
        foreach($rights as $rightId){
            $newRight = new RoleHasRight();
            $newRight->right_id = $rightId;
            $newRight->role_id  = $this->id;
            $newRight->created  = new Expression('NOW()');
            if(!$newRight->save()){
                Yii::error(json_encode($newRight->getErrors())." beim Speichern der Rollenrechte");
                return false;
            }
        };
        return true;
    }

    
    public function search(){
        $search = Role::find();
        if($this->name != null)
            $search->andWhere(['like','name',$this->name]);
        return $search;
    }    
    
    
    
    
}
