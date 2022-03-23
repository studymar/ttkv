<?php
use app\models\user\User;
use Step\Acceptance\Login;

class LoginFormCest
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
    
    public function login($I){
//        $I->see('Login', 'h2');
//        $I->fillField("#loginform-email", "test@googlemail.com");
//        $I->fillField("#loginform-password", "harburg2416z");
//        $I->click('Login');
        $user = $I->grabFixture('users','ValidatedUser');
        $I->amLoggedInAs($user);
    }
    

    public function openLoginPage(\FunctionalTester $I)
    {
        $I->amOnRoute('account/index');
        $I->see('Login', 'h2');
    }
    public function loginByLoginPage(\FunctionalTester $I)
    {
        $I->amOnRoute('account/index');
        $I->see('Login', 'h2');

        $user = $I->grabFixture('users','ValidatedUser');
        $I->fillField("#loginform-email", $user->email);
        $I->fillField("#loginform-password", "harburg2416z");
        $I->click('Login');
        
        $I->see('Mein Menü', '#myMenuButton');
    }

    /**
     * @skip
     * @param \FunctionalTester $I
     */
    public function correctUserAfterLogin(\FunctionalTester $I)
    {
        $user = $I->grabFixture('users','ValidatedUser');
        $I->amLoggedInAs($user);
        $I->amOnRoute('account/home');
        //TODO
        //$I->canSee("Test Tester");
    }

    public function logout(\FunctionalTester $I)
    {
        $user = $I->grabFixture('users','ValidatedUser');
        $I->amLoggedInAs($user);
        $I->amOnRoute('account/home');
        $I->click("#myMenuButton");
        $I->see("Logout");
        $I->click('Logout');
        $I->see("Anmelden");
        
    }
    

}
