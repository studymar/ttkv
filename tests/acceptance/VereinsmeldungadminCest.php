<?php

use yii\helpers\Url;
use Page\Acceptance\user\VereinsmeldeUserTestdata;
use Page\Acceptance\Fixturedata;
use Page\Acceptance\Seasondata;
use app\models\Vereinsmeldung\Season;

class VereinsmeldungadminCest
{
    public function _fixtures()
    {
        return Fixturedata::getFixtures();
    }
    
    
    public function showSeasons(AcceptanceTester $I, \Page\Acceptance\Login $IHelper)
    {
        $IHelper->amLoggedInAs(VereinsmeldeUserTestdata::getUser('email'), VereinsmeldeUserTestdata::getPassword());
        $I->amOnPage( \yii\helpers\Url::toRoute(['/vereinsmeldungadmin/index']));
        $I->waitForElement("#vereinsmeldungadmin-uebersicht");
        //mind. ein meldemodul zu sehen
        $I->seeElement('#item-new');
        $I->seeElement('#item-1');
                
    }

    
    
    public function createSeason(AcceptanceTester $I, \Page\Acceptance\Login $IHelper)
    {
        $IHelper->amLoggedInAs(VereinsmeldeUserTestdata::getUser('email'), VereinsmeldeUserTestdata::getPassword());
        $I->amOnPage( \yii\helpers\Url::toRoute(['/vereinsmeldungadmin/create-season']));
        $I->waitForElement("#seasonedit-form");
        //mind. ein meldemodul zu sehen
        $I->seeElement("#edit-1");
        
        //fill name
        $seasonname = "2023";
        $I->fillField('#seasoneditform-name', $seasonname);
        
        //checkboxen
        $checkBox1 = "#edit-1";
        $checkBox2 = "#edit-2";
        $checkBox3 = "#edit-3";
        $checkBox4 = "#edit-4";
        $checkBox5 = "#edit-5";
        $checkBox6 = "#edit-6";
        
        //check and uncheck
        $I->amGoingTo('check only Checkboxes 1,2,3,4 and uncheck the rest');
        $I->checkOption($checkBox1);//check
        $I->checkOption($checkBox2);//check
        $I->checkOption($checkBox3);//check
        $I->checkOption($checkBox4);//check

        $I->uncheckOption($checkBox5);//uncheck
        $I->uncheckOption($checkBox6);//uncheck


        $I->click('.btn-primary');

        //wieder in listenansicht?
        $I->expectTo("see the list again after saving");
        $I->waitForElement("#vereinsmeldungadmin-uebersicht");
        //season zu sehen?
        $I->see($seasonname);

        //editiere angelegte Saison, um zu pruefen, ob alles korrekt angelegt
        //$I->click($seasonname);
        $newestId = Season::getNewestSeasonId();
        $I->amOnPage( \yii\helpers\Url::toRoute(['/vereinsmeldungadmin/edit-season','p'=>$newestId]));
        $I->waitForElement("#seasonedit-form");
        
        $I->seeInField('#seasoneditform-name',$seasonname);//saved Name successfull?
        $I->seeCheckboxIsChecked($checkBox1);
        $I->seeCheckboxIsChecked($checkBox2);
        $I->seeCheckboxIsChecked($checkBox3);
        $I->seeCheckboxIsChecked($checkBox4);

        $I->dontSeeCheckboxIsChecked($checkBox5);
        $I->dontSeeCheckboxIsChecked($checkBox6);
                
    }


    public function editSeason(AcceptanceTester $I, \Page\Acceptance\Login $IHelper)
    {
        $IHelper->amLoggedInAs(VereinsmeldeUserTestdata::getUser('email'), VereinsmeldeUserTestdata::getPassword());
        $I->amOnPage( \yii\helpers\Url::toRoute(['/vereinsmeldungadmin/edit-season','p'=>Seasondata::getSeason('id')]));
        $I->waitForElement("#seasonedit-form");
        //mind. ein meldemodul zu sehen
        $I->seeElement("#edit-1");
        
        //fill name
        $seasonname = Seasondata::getSeason('name');
        $changed_seasonname = $seasonname."b";
        $I->fillField('#seasoneditform-name', $changed_seasonname);
        
        //checkboxen
        $checkBox1 = "#edit-1";
        $checkBox2 = "#edit-2";
        $checkBox3 = "#edit-3";
        $checkBox4 = "#edit-4";
        $checkBox5 = "#edit-5";
        $checkBox6 = "#edit-6";
        
        //check and uncheck
        $I->amGoingTo('check only Checkboxes 1,2,3 and uncheck the rest');
        $I->checkOption($checkBox1);//check
        $I->checkOption($checkBox2);//check
        $I->checkOption($checkBox3);//check

        $I->uncheckOption($checkBox4);//uncheck
        $I->uncheckOption($checkBox5);//uncheck
        $I->uncheckOption($checkBox6);//uncheck

        $I->click('.btn-primary');

        //wieder in listenansicht?
        $I->expectTo("see the list again after saving");
        $I->waitForElement("#vereinsmeldungadmin-uebersicht");
        //season zu sehen?
        $I->see($changed_seasonname);
        
        //editiere angelegte Saison, um zu pruefen, ob alles korrekt angelegt
        $I->amOnPage( \yii\helpers\Url::toRoute(['/vereinsmeldungadmin/edit-season','p'=>Seasondata::getSeason('id')]));
        $I->waitForElement("#seasonedit-form");
        
        $I->seeInField('#seasoneditform-name',$changed_seasonname);//saved Name successfull?
        $I->seeCheckboxIsChecked($checkBox1);
        $I->seeCheckboxIsChecked($checkBox2);
        $I->seeCheckboxIsChecked($checkBox3);

        $I->dontSeeCheckboxIsChecked($checkBox4);
        $I->dontSeeCheckboxIsChecked($checkBox5);
        $I->dontSeeCheckboxIsChecked($checkBox6);
                
    }

    public function deleteSeason(AcceptanceTester $I, \Page\Acceptance\Login $IHelper)
    {
        $IHelper->amLoggedInAs(VereinsmeldeUserTestdata::getUser('email'), VereinsmeldeUserTestdata::getPassword());
        $I->amOnPage( \yii\helpers\Url::toRoute(['/vereinsmeldungadmin/edit-season','p'=>Seasondata::getSeason('id')]));
        $I->waitForElement("#seasonedit-form");
        //mind. ein meldemodul zu sehen
        $I->seeElement("#edit-1");
        
        //delete
        $I->click('.btn-danger');

        //wieder in listenansicht?
        $I->expectTo("see the list again after saving");
        $I->waitForElement("#vereinsmeldungadmin-uebersicht");
        //season nicht mehr zu sehen?
        $deleted_seasonname = Seasondata::getSeason('name');
        $I->dontsee($deleted_seasonname);
                        
    }

    
}
