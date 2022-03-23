<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "verein".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $vereinsnummer
 * @property string|null $foundation_year_verein
 * @property string|null $foundation_year_abteilung
 * @property string|null $homepage
 * @property DateTime|null $deleted
 */
class Verein extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'verein';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'vereinsnummer', 'homepage'], 'string'],
            [['foundation_year_verein', 'foundation_year_abteilung'], 'string', 'max' => 4],
            [['deleted'], 'safe'],
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
            'vereinsnummer' => 'Vereinsnummer',
            'foundation_year_verein' => 'Foundation Year Verein',
            'foundation_year_abteilung' => 'Foundation Year Abteilung',
            'homepage' => 'Homepage',
        ];
    }
    
    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['vereins_id' => 'id']);
    }
    
}
