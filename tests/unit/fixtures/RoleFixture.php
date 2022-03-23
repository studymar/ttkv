<?php
namespace tests\unit\fixtures;

use yii\test\ActiveFixture;

class RoleFixture extends ActiveFixture
{
    public $modelClass = 'app\models\user\Role';
    //public $depends = ['app\tests\fixtures\RoleHasRightFixture'];
}