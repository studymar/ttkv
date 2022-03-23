<?php
//namespace app\tests\unit\fixtures;
namespace app\tests\fixtures;

use yii\test\ActiveFixture;

class UserFixture extends ActiveFixture
{
    public $modelClass = 'app\models\user\User';
    //public $depends = ['app\tests\fixtures\RoleFixture'];
}