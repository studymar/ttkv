<?php
use app\models\user\User;
use Step\Acceptance\Login;

class RolemanagerCest
{
    public function _fixtures()
    {
        //return ['users' => \app\tests\fixtures\UserFixture::className()];
        return [
            'roles' => [
                'class' => \app\tests\fixtures\RoleFixture::class,
                'dataFile' => codecept_data_dir() . 'role.php'
            ],
            'rights' => [
                'class' => \app\tests\fixtures\RightFixture::class,
                'dataFile' => codecept_data_dir() . 'right.php'
            ],
            'roleHasRight' => [
                'class' => \app\tests\fixtures\RoleHasRightFixture::class,
                'dataFile' => codecept_data_dir() . 'role_has_right.php'
            ],
            'rightgroups' => [
                'class' => \app\tests\fixtures\RightgroupFixture::class,
                'dataFile' => codecept_data_dir() . 'rightgroup.php'
            ],
            'users' => [
                'class' => \app\tests\fixtures\UserFixture::class,
                'dataFile' => codecept_data_dir() . 'user.php'
            ],
        ];
    }    
    
    public function _before(\FunctionalTester $I)
    {
    }
    
    public function openRolemanager(\FunctionalTester $I)
    {
        $user = $I->grabFixture('users','AdminUser');
        $I->amLoggedInAs($user);
        $I->amOnRoute('rolemanager/index');
        $I->see("Rolemanager",'h2');
        $I->seeElement('#rolemanager-list');
    }
    

}
