<?php
use app\models\user\User;
use Step\Acceptance\Login;

class AccountCest
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
    
    public function openAnmelden1(\FunctionalTester $I)
    {
        $I->amOnRoute('account/index');
        $link = '#anmelde-link';
        $I->seeElement($link);
        $I->click($link);
        $I->seeElement('#registrationform-firstname');
    }
    public function submitAnmelden(\FunctionalTester $I)
    {
        $user = $I->grabFixture('users','ValidatedUser');
        $I->amOnRoute('account/anmelden');
        
        //anmelden 1
        $I->fillField('#registrationform-firstname', $user->firstname);
        $I->fillField('#registrationform-lastname', $user->lastname);
        $I->fillField('#registrationform-email', 'abc'.$user->email);//vorn etwas dran, weil sonst mail schon vorhanden
        $I->fillField('#registrationform-password', $user->password);
        $I->fillField('#registrationform-password_repeat', $user->password);
        $I->click('.btn-primary');
        
        //anmelden 2
        $I->seeElement('.radioListAsLine input');
        $I->selectOption('.radioListAsLine input', '27');
        $I->click('.btn-primary');
        
        //anmelden 3 Bestätigung
        $I->see('Email:');
        $I->click('.btn-primary');
        //Bestätigung
        $I->see("Anmeldung bestätigen");
    }

    public function anmeldungBestaetigen(\FunctionalTester $I)
    {
        $unvuser = $I->grabFixture('users','UnvalidatedUser');
        //$I->amOnPage('account/anmeldung-abschliessen/'.$user->passwordforgottentoken);
        $I->amOnRoute('account/anmeldung-abschliessen',['p'=>$unvuser->validationtoken]);
        $I->see("Anmeldung abgeschlossen");
        
    }    
    
    public function openForgottenPassword(\FunctionalTester $I)
    {
        $I->amOnRoute('account/index');
        $link = '#pw-forgotten-link';
        $I->seeElement($link);
        $I->click($link);
        $I->seeElement('#forgottenpasswordform-email');
    }
    
    public function submitForgottenPassword(\FunctionalTester $I)
    {
        $user = $I->grabFixture('users','ValidatedUser');
        //pw forgotton open by link on login-page
        $I->amOnRoute('account/index');
        $link = '#pw-forgotten-link';
        $I->seeElement($link);
        $I->click($link);
        
        //pw forgotton open?
        $emailField = '#forgottenpasswordform-email';
        $I->seeElement($emailField);
        $I->fillField($emailField, $user->email);
        //submit
        $I->click('#pw-forgotten-submit');
        //success?
        $I->seeElement('#mail-sent-text');
    }

//    public function resetPassword(\FunctionalTester $I)
//    {
//        $user = $I->grabFixture('users','ResetPasswordUser');
//        //$I->amOnPage('account/anmeldung-abschliessen/'.$user->passwordforgottentoken);
//        $I->amOnRoute('account/reset-password',['p'=>$user->passwordforgottentoken]);
//        $I->see("Neues Passwort setzen");
//        $field  = '#forgottenpasswordresetform-password';
//        $field2 = '#forgottenpasswordresetform-password_repeat';
//        $I->seeElement($field);
//        $I->seeElement($field2);
//        $I->fillField($field, 'neuespasswort1'); // geändertes Passwort
//        $I->fillField($field2, 'neuespasswort1'); // geändertes Passwort
//        $I->click('.btn-primary');
//        
//        $I->see("Passwort geändert");
//        
//    }    

    
    public function openMyMenue(\FunctionalTester $I)
    {
        $user = $I->grabFixture('users','ValidatedUser');
        $I->amLoggedInAs($user);
        $I->amOnRoute('account/home');
        $I->click("#myMenuButton");
        $I->see("Logout");
    }
    
    

}
