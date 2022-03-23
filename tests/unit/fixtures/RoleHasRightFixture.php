<?php
namespace tests\unit\fixtures;

use yii\test\ActiveFixture;

class RoleHasRightFixture extends ActiveFixture
{
    public $modelClass = 'app\models\user\RoleHasRight';
    //public $depends = ['app\tests\fixtures\RightFixture'];
}