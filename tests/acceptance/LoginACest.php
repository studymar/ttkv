<?php

use yii\helpers\Url;
use Page\Acceptance\Fixturedata;

class LoginACest
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

    public function openLogin(AcceptanceTester $I)
    {
        $I->amOnPage( \yii\helpers\Url::toRoute(['/account/index']));
        $I->see('Login','h2');
        
    }

    public function processLogin(AcceptanceTester $I, \Page\Acceptance\Login $IHelper)
    {
        $I->amOnPage( \yii\helpers\Url::toRoute(['/account/index']));
        $I->wait(1);
        $I->fillField('#loginform-email', $IHelper->LoginUserEmail); // geändertes Passwort
        $I->fillField('#loginform-password', $IHelper->LoginUserPassword); // geändertes Passwort
        $I->click('.btn-primary');
        $I->wait($IHelper->waitTime);

        $I->see("Schaltzentrale deines Vereins im TTKV:"); 
    }

    public function processLoginValidationFailure(AcceptanceTester $I, \Page\Acceptance\Login $IHelper)
    {
        $I->amOnPage( \yii\helpers\Url::toRoute(['/account/index']));
        $I->wait(1);
        $I->fillField('#loginform-email', $IHelper->LoginUserEmail); // geändertes Passwort
        $I->fillField('#loginform-password', $IHelper->LoginUserPassword."Failure"); // geändertes Passwort
        $I->click('.btn-primary');
        $I->wait($IHelper->waitTime);

        //wegen falschem PW wieder auf Loginseite?
        $I->dontSee("Schaltzentrale deines Vereins im TTKV:"); 
        $I->seeElement('#loginform-email');
    }

    public function processLoginLockedFailure(AcceptanceTester $I, \Page\Acceptance\Login $IHelper)
    {
        $I->amOnPage( \yii\helpers\Url::toRoute(['/account/index']));
        $I->wait($IHelper->waitTime);
        $I->fillField('#loginform-email', $IHelper->LoginLockedUserEmail); // geändertes Passwort
        $I->fillField('#loginform-password', $IHelper->LoginLockedUserPassword); // geändertes Passwort
        $I->click('.btn-primary');
        $I->wait($IHelper->waitTime);

        //wegen falschem PW wieder auf Loginseite?
        $I->dontSee("Schaltzentrale deines Vereins im TTKV:"); 
        $I->seeElement('#loginform-email');
    }
    
    public function processLoginUnvalidatedUserFailure(AcceptanceTester $I, \Page\Acceptance\Login $IHelper)
    {
        $I->amOnPage( \yii\helpers\Url::toRoute(['/account/index']));
        $I->wait($IHelper->waitTime);
        $I->fillField('#loginform-email', $IHelper->LoginUnvalidatedUserEmail); // geändertes Passwort
        $I->fillField('#loginform-password', $IHelper->LoginUnvalidatedUserPassword); // geändertes Passwort
        $I->click('.btn-primary');
        $I->wait($IHelper->waitTime);

        //wegen falschem PW wieder auf Loginseite?
        $I->dontSee("Schaltzentrale deines Vereins im TTKV:"); 
        $I->seeElement('#loginform-email');
    }
    
    public function seeHomeAfterLogin(AcceptanceTester $I, \Page\Acceptance\Login $IHelper)
    {
        $IHelper->amLoggedInAsAdmin();
        $I->wait($IHelper->waitTime);
        $I->see("Schaltzentrale deines Vereins im TTKV:"); 
    }


    
}
