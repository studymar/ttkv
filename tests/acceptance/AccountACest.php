<?php

use yii\helpers\Url;
use Page\Acceptance\Fixturedata;

class AccountACest
{
    public function _fixtures()
    {
        return Fixturedata::getFixtures();
        /*
        //return ['users' => \app\tests\fixtures\UserFixture::className()];
        return [
            'vereine' => [
                'class' => \app\tests\fixtures\VereinFixture::class,
                'dataFile' => codecept_data_dir() . 'verein.php'
            ],
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
         */
    }    
    
    
    public function resetPassword(AcceptanceTester $I, \Page\Acceptance\Login $IHelper)
    {
        $I->expect('/account/reset-password');
        $I->amOnPage( \yii\helpers\Url::toRoute(['/account/reset-password','p'=>'BfH2FR3JIdWW2qBfzFxEQbXjT6yQeuWkoooo']));

        $I->see("Neues Passwort setzen");
        $field  = '#forgottenpasswordresetform-password';
        $field2 = '#forgottenpasswordresetform-password_repeat';
        $I->seeElement($field);
        $I->seeElement($field2);
        $I->fillField($field, 'neuespasswort1'); // geändertes Passwort
        $I->fillField($field2, 'neuespasswort1'); // geändertes Passwort
        $I->click('.btn-primary');

        $I->wait($IHelper->waitTime);
        $I->see("Passwort geändert");
                
    }

    public function resetPasswordWrongToken(AcceptanceTester $I, \Page\Acceptance\Login $IHelper)
    {
        $I->amOnPage( \yii\helpers\Url::toRoute(['/account/reset-password','p'=>'BfH2FR3JIdWW2qBfzFxEQbXjT6yQeuWkooooWrong']));
        $I->dontSee("Neues Passwort setzen");
        $field  = '#forgottenpasswordresetform-password';
        $field2 = '#forgottenpasswordresetform-password_repeat';
        $I->dontSee($field);
        $I->dontSee($field2);
                
    }    
    
    public function resetPasswordForbiddenCauseOfExpiredToken(AcceptanceTester $I, \Page\Acceptance\Login $IHelper)
    {
        $I->amOnPage( \yii\helpers\Url::toRoute(['/account/reset-password','p'=>'BfH2FR3JIdWW2qBfzFxEQbXjT6yQeuWkooooexpired']));
        $I->dontSee("Neues Passwort setzen");
        $field  = '#forgottenpasswordresetform-password';
        $field2 = '#forgottenpasswordresetform-password_repeat';
        $I->dontSee($field);
        $I->dontSee($field2);
                
    }
    
    public function editMydata(AcceptanceTester $I, \Page\Acceptance\Login $IHelper)
    {
        //$IHelper->amLoggedInAsStandard();
        $IHelper->amLoggedInAsEditDataUser();
        
        $I->amOnPage( \yii\helpers\Url::toRoute(['/account/mydata']));
        $I->see("Meine Daten",'h2');

        $I->expectTo("see my prefilled data in mydata-formular");
        $I->seeInField('#mydataeditform-firstname', $IHelper->EditdataUserFirstname);
        $I->seeInField('#mydataeditform-lastname', $IHelper->EditdataUserLastname);
        
        $newName = "MydataB";
        $I->fillField("#mydataeditform-lastname", $newName);//changeName
        $I->click('#mydata-submit-btn');
        $I->waitForElement('#account-home-list');

        $I->expectTo("see Home after Login");
        $I->see('Schaltzentrale');
        
        $I->expectTo("see changed data in mydata-formular");
        $I->amOnPage( \yii\helpers\Url::toRoute(['/account/mydata']));
        $I->waitForElement('#account-mydata');
        
        $I->seeInField('#mydataeditform-lastname', $newName);
                        
    }
    
    public function editMydataChangePassword(AcceptanceTester $I, \Page\Acceptance\Login $IHelper)
    {
        $IHelper->amLoggedInAsMyDataUser();
        
        $I->amOnPage( \yii\helpers\Url::toRoute(['/account/mydata']));
        $I->waitForElement('#account-mydata');
        $I->see("Meine Daten",'h2');
        
        $I->amGoingTo("fill my new password");
        $newPw = "NewPassword123";
        $I->fillField("#changepasswordform-password", $newPw);//changeName
        $I->fillField("#changepasswordform-password_repeat", $newPw);//changeName
        $I->click('#changepassword-submit-btn');
        $I->waitForElement('#account-home-list');
        
        $I->expectTo("see Home after change");
        $I->see('Schaltzentrale');
    }    
    
}
