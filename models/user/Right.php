<?php

namespace app\models\user;

use Yii;

/**
 * This is the model class for table "right".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $route
 *
 * @property RoleHasRight[] $roleHasRights
 * @property Role[] $roles
 */
class Right extends \yii\db\ActiveRecord
{
    //IDs <100 Kreisrechte
    const ID_RIGHT_USERMANAGER = "1";
    const ID_RIGHT_ROLEMANAGER = "2";

    //verein
    const ID_RIGHT_VEREINSMELDUNG       = "3";
    const ID_RIGHT_VEREINSKONTAKTE      = "4";
    
    //kreis
    const ID_RIGHT_VEREINSMELDUNG_KONFIGURIEREN = "5";
    const ID_RIGHT_VEREINSKONTAKTE_EINSEHEN     = "6";
    const ID_RIGHT_VEREINSMELDUNGEN_EINSEHEN    = "7";
    const ID_RIGHT_KREISKONTAKTE_PFLEGEN        = "8";
    
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'right';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['route'], 'string', 'max' => 255],
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
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[RoleHasRights]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRoleHasRights()
    {
        return $this->hasMany(RoleHasRight::className(), ['right_id' => 'id']);
    }

    /**
     * Gets query for [[Roles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRoles()
    {
        return $this->hasMany(Role::className(), ['id' => 'role_id'])->viaTable('role_has_right', ['right_id' => 'id']);
    }
    
    
}
