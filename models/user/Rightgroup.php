<?php

namespace app\models\user;

use Yii;

/**
 * This is the model class for table "rightgroup".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $sort
 *
 * @property Right[] $rights
 */
class Rightgroup extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rightgroup';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sort'], 'integer'],
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
            'sort' => 'Sort',
        ];
    }

    /**
     * Gets query for [[Rights]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRights()
    {
        return $this->hasMany(Right::className(), ['rightgroup_id' => 'id']);
    }
    
    /**
     * Gets query for [[Rights]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRightsIndexed()
    {
        return $this->hasMany(Right::className(), ['rightgroup_id' => 'id'])->select('name')->indexBy('id')->column();
    }
    
}
