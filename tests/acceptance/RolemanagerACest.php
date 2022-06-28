<?php

use yii\helpers\Url;
use Page\Acceptance\Fixturedata;

class RolemanagerACest
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
    
    
    public function seeRolemanagerInMyMenueAsAdmin(AcceptanceTester $I, \Page\Acceptance\Login $IHelper)
    {
        $IHelper->amLoggedInAsAdmin();

        $I->seeLink("Rolemanager"); 
    }
    
    public function doNotSeeRolemanagerInMyMenueAsStandard(AcceptanceTester $I, \Page\Acceptance\Login $IHelper)
    {
        $IHelper->amLoggedInAsStandard();

        $I->dontSeeLink("Rolemanager"); 
    }

    public function seeRolemanagerList(AcceptanceTester $I, \Page\Acceptance\Login $IHelper)
    {
        $IHelper->amLoggedInAsAdmin();

        $I->seeLink("Rolemanager");
        $I->click("Rolemanager");
        $I->waitForElement('#rolemanager-list');
        $I->seeElement('#rolemanager-list');
    }

    
    public function edit(AcceptanceTester $I, \Page\Acceptance\Login $IHelper)
    {
        $IHelper->amLoggedInAsAdmin();
        $I->wait($IHelper->waitTime);
        $I->seeLink("Rolemanager");
        $I->click("Rolemanager");
        $I->waitForElement('#rolemanager-list');

        $I->seeElement('#rolemanager-list');
        $I->see('Standard');
        $I->click('Standard');
        $I->waitForElement("#roleeditform-name");

        //editmaske
        $I->expectTo("to see the edit page");
        $I->see('Rolle Editieren');
        $newName = "StandardB";
        $I->fillField("#roleeditform-name", $newName);//changeName
        
        //checkboxen
        $checkBox1 = "#edit-1";
        $checkBox2 = "#edit-2";
        $checkBox3 = "#edit-3";
        $checkBox4 = "#edit-4";
        $checkBox5 = "#edit-5";
        
        //check and uncheck
        $I->amGoingTo('check only Checkboxes 3,4 and uncheck the rest');
        $I->uncheckOption($checkBox1);//check
        $I->uncheckOption($checkBox2);//check

        $I->checkOption($checkBox3);//check
        $I->checkOption($checkBox4);//check

        $I->uncheckOption($checkBox5);//check
        $I->click('.btn-primary');
        $I->waitForElement('#rolemanager-list');

        //wieder in listenansicht?
        $I->expectTo("see the list again after saving");
        $I->seeElement('#rolemanager-list');
        $I->click($newName);
        $I->waitForElement("#roleeditform-name");
        
        //nochmal rein und prüfen, ob übernommen
        $I->expect('that only Checkbox 3,4 are checked');
        $I->see('Rolle Editieren');
        $I->seeInField('#roleeditform-name',$newName);//changed Name successfull?
        $I->dontSeeCheckboxIsChecked($checkBox1);
        $I->dontSeeCheckboxIsChecked($checkBox2);

        $I->seeCheckboxIsChecked($checkBox3);
        $I->seeCheckboxIsChecked($checkBox4);

        $I->dontSeeCheckboxIsChecked($checkBox5);
        
        //zuruecksetzen
    }
    
}
