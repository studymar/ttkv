<?php use app\models\user\User;
use Step\Acceptance\Login;

//class UsermanagerCest
//{
//    public function _fixtures()
//    {
//        //return ['users' => \app\tests\fixtures\UserFixture::className()];
//        return [
//            'users' => [
//                'class' => \app\tests\fixtures\UserFixture::class,
//                'dataFile' => codecept_data_dir() . 'user.php'
//            ],
//        ];
//    }    
//    
//    public function _before(\FunctionalTester $I)
//    {
//    }
//
//
//    public function seeUsermanagerInMyMenue(\FunctionalTester $I)
//    {
//        $user = $I->grabFixture('users','AdminUser');
//        $I->amLoggedInAs($user);
//        $I->amOnRoute('account/home');
//        
//        $I->see("Usermanager",'.list a');
//    }
//    
//    public function openUsermanager(\FunctionalTester $I)
//    {
//        $user = $I->grabFixture('users','AdminUser');
//        $I->amLoggedInAs($user);
//        $I->amOnRoute('usermanager/index');
//        $I->see("Usermanager",'h2');
//        $I->seeElement('#usermanager-list');
//    }
//
//}
