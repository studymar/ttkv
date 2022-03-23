<?php

namespace app\models\user;

use Yii;

/**
 * This is the model class for table "role_has_right".
 *
 * @property int $role_id
 * @property int $right_id
 *
 * @property Right $right
 * @property Role $role
 */
class RoleHasRight extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'role_has_right';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['role_id', 'right_id'], 'required'],
            [['role_id', 'right_id'], 'integer'],
            [['role_id', 'right_id'], 'unique', 'targetAttribute' => ['role_id', 'right_id']],
            [['right_id'], 'exist', 'skipOnError' => true, 'targetClass' => Right::className(), 'targetAttribute' => ['right_id' => 'id']],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => Role::className(), 'targetAttribute' => ['role_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'role_id' => 'Role ID',
            'right_id' => 'Right ID',
        ];
    }

    /**
     * Gets query for [[Right]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRight()
    {
        return $this->hasOne(Right::className(), ['id' => 'right_id']);
    }

    /**
     * Gets query for [[Role]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(Role::className(), ['id' => 'role_id']);
    }
}
