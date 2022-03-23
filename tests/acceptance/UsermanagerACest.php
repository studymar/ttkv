<?php

use yii\helpers\Url;

class UsermanagerACest
{
    public function _fixtures()
    {
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
    }    
    
    public function seeUsermanagerAsAdmin(AcceptanceTester $I, \Page\Acceptance\Login $IHelper)
    {
        $IHelper->amLoggedInAsAdmin();

        //$I->wait($IHelper->waitTime);
        $I->waitForElement('#account-home-list');
        $I->seeLink("Usermanager"); 
    }
    
    public function doNotSeeUsermanagerAsStandard(AcceptanceTester $I, \Page\Acceptance\Login $IHelper)
    {
        $IHelper->amLoggedInAsStandard();
        //$I->wait($IHelper->waitTime);
        $I->waitForElement('#account-home-list');
        $I->dontSeeLink("Usermanager"); 
    }

    public function seeUsermanagerList(AcceptanceTester $I, \Page\Acceptance\Login $IHelper)
    {
        $IHelper->amLoggedInAsAdmin();
        $I->waitForElement('#account-home-list');

        $I->seeLink("Usermanager");
        $I->click("Usermanager");
        $I->waitForElement('#usermanager-list');
        $I->seeElement('#usermanager-list');
    }
    
    public function canEditUser(AcceptanceTester $I, \Page\Acceptance\Login $IHelper)
    {
        $IHelper->amLoggedInAsAdmin();
        $I->waitForElement('#account-home-list');
        $I->seeLink("Usermanager");
        $I->click("Usermanager");

        $I->seeElement('#usermanager-list');
        $I->see($IHelper->StandardUserName);
        $I->seeElement('#editlink-user-'.$IHelper->StandardUserID);
        $I->click('#editlink-user-'.$IHelper->StandardUserID);

        $I->see('User Editieren');
        $newName = "StandardB";
        $I->fillField("#usereditform-lastname", $newName);//changeName
        $I->checkOption("#usereditform-locked");//disable User
        $I->click('.btn-primary');

        $I->waitForElement('#usermanager-list');
        $I->seeElement('#usermanager-list');
        $I->seeElement('.locked-user');
        $I->see($newName);//changed Name successfull?
        
    }
    
    public function canEditUserVerein(AcceptanceTester $I, \Page\Acceptance\Login $IHelper)
    {
        $IHelper->amLoggedInAsAdmin();
        $I->waitForElement('#account-home-list');
        $I->seeLink("Usermanager");
        $I->click("Usermanager");
        $I->waitForElement('#usermanager-list');

        //list
        $I->seeElement('#usermanager-list');
        $I->see($IHelper->EditVereinUserName);
        $I->seeElement('#editlink-user-'.$IHelper->EditVereinUserID);
        $I->click('#editlink-user-'.$IHelper->EditVereinUserID);
        $I->waitForElement('#user-edit');
        
        //user edit
        $I->see('User Editieren');
        $I->seeElement('#editVerein-Link');
        $I->click('#editVerein-Link');
        $I->waitForElement('#editVerein');

        //verein auswahl
        $I->seeElement('#editVerein');
        $I->seeElementInDOM('.radioListAsLine input');
        $newVerein = '6';
        //$I->selectOption('.radioListAsLine input', $newVerein);
        $I->click('#item-'.$newVerein);
        $I->click('.btn-primary');
        $I->waitForElement('#user-edit');
        
        //user edit
        $I->seeElement('#user-verein-'.$newVerein);
        

    }    
    
}
