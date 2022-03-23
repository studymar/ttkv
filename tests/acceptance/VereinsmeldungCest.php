<?php

use yii\helpers\Url;
use Page\Acceptance\user\VereinsmeldeUserTestdata;
use Page\Acceptance\Fixturedata;

class VereinsmeldungCest
{
    public function _fixtures()
    {
        return Fixturedata::getFixtures();
    }    
    
    
    public function vereinsmeldungUebersicht(AcceptanceTester $I, \Page\Acceptance\Login $IHelper)
    {
        $IHelper->amLoggedInAs(VereinsmeldeUserTestdata::getUser('email'), VereinsmeldeUserTestdata::getPassword());
        $I->expect('/vereinsmeldung/index');
        $I->amOnPage( \yii\helpers\Url::toRoute(['/vereinsmeldung/index']));
        $I->waitForElement("#vereinsmeldung-uebersicht");
        //mind. ein meldemodul zu sehen
        $I->seeElement('#item-1');
                
    }


    public function vereinsmeldungVereinskontakteNotDoneAtStart(AcceptanceTester $I, \Page\Acceptance\Login $IHelper)
    {
        $IHelper->amLoggedInAs(VereinsmeldeUserTestdata::getUser('email'), VereinsmeldeUserTestdata::getPassword());
        $I->amOnPage( \yii\helpers\Url::toRoute(['/vereinsmeldung/index']));
        $I->waitForElement("#vereinsmeldung-uebersicht");
        //kein success beim vereinskontakt, weil noch nicht eingegeben
        $I->seeElement('#vereinsmeldemodul-1 .text-danger');
                
    }

    public function vereinsmeldungOpenVereinskontakte(AcceptanceTester $I, \Page\Acceptance\Login $IHelper)
    {
        $IHelper->amLoggedInAs(VereinsmeldeUserTestdata::getUser('email'), VereinsmeldeUserTestdata::getPassword());

        $item = new Page\Acceptance\CreateEditDeleteSeasondata();
        $vereinsmeldung_id = $item->getVereinsmeldungData('id');
        $I->amOnPage( \yii\helpers\Url::toRoute(['/vereinsmeldung/vereinskontakte','p'=>$vereinsmeldung_id]));

        $I->waitForElement("#vereinskontakte");
        //kein success beim vereinskontakt, weil noch nicht eingegeben
        $I->seeElement('#no-vereinskontakte');
                
    }

    public function vereinsmeldungVereinskontakteAddPersonAndDelete(AcceptanceTester $I, \Page\Acceptance\Login $IHelper)
    {
        $IHelper->amLoggedInAs(VereinsmeldeUserTestdata::getUser('email'), VereinsmeldeUserTestdata::getPassword());

        $item = new Page\Acceptance\CreateEditDeleteSeasondata();
        $vereinsmeldung_id = $item->getVereinsmeldungData('id');
        $I->amOnPage( \yii\helpers\Url::toRoute(['/vereinsmeldung/vereinskontakte','p'=>$vereinsmeldung_id]));

        $I->waitForElement("#vereinskontakte");
        //kein success beim vereinskontakt, weil noch nicht eingegeben
        $I->seeElement('#no-vereinskontakte');
        $I->click('#item-new-link');
        $I->waitForElement("#persondata");
        
        $firstname  = 'myFirstname';
        $lastname   = 'myLastname';
        $email      = 'person@ttkv-harburg.de';
        $I->fillField('#personeditform-firstname', $firstname);
        $I->fillField('#personeditform-lastname', $lastname);
        $I->fillField('#personeditform-email', $email);
        //keine rolle anklicken, nur Person
        $I->scrollTo('.btn-primary');
        $I->wait(1);
        $I->click('.btn-primary');

        $I->waitForElement("#vereinskontakte");
        //eingefügt und auf vereinskontaktseite zu sehen?
        $I->see($firstname." ".$lastname);
        
        //nochmal in edit-seite und pruefen, ob daten richtig
        $I->click('#person-'.$lastname);
        $I->waitForElement("#persondata");
        
        $I->scrollTo('.btn-danger');
        $I->wait(1);
        $I->click('.btn-danger');

        $I->waitForElement("#vereinskontakte");
        $I->dontSee($firstname." ".$lastname);
    }
    
    
    public function vereinsmeldungVereinskontakteAddPersonAndEdit(AcceptanceTester $I, \Page\Acceptance\Login $IHelper)
    {
        $IHelper->amLoggedInAs(VereinsmeldeUserTestdata::getUser('email'), VereinsmeldeUserTestdata::getPassword());

        $item = new Page\Acceptance\CreateEditDeleteSeasondata();
        $vereinsmeldung_id = $item->getVereinsmeldungData('id');
        $I->amOnPage( \yii\helpers\Url::toRoute(['/vereinsmeldung/vereinskontakte','p'=>$vereinsmeldung_id]));

        $I->waitForElement("#vereinskontakte");
        $I->click('#item-new-link');
        $I->waitForElement("#persondata");
        
        $firstname  = 'myFirstname';
        $lastname   = 'myLastname';
        $email      = 'person@ttkv-harburg.de';
        $I->fillField('#personeditform-firstname', $firstname);
        $I->fillField('#personeditform-lastname', $lastname);
        $I->fillField('#personeditform-email', $email);
        $I->click('#item-1'); //Rolle Abteilungsleiter
        $I->scrollTo('.btn-primary');
        $I->wait(1);
        $I->click('.btn-primary');

        $I->waitForElement("#vereinskontakte");
        //eingefügt und auf vereinskontaktseite zu sehen?
        $I->see($firstname." ".$lastname);
        $I->see("Abteilungsleiter");
        
        //nochmal in edit-seite und pruefen, ob daten richtig
        $I->click('#person-'.$lastname);
        $I->waitForElement("#persondata");
        
        $I->seeInField('#personeditform-firstname', $firstname);
        $I->seeInField('#personeditform-lastname', $lastname);
        $I->seeInField('#personeditform-email', $email);
        $I->scrollTo('.btn-primary');
        $I->wait(1);
        $I->click('.btn-primary');

        $I->waitForElement("#vereinskontakte");
    }


    public function vereinsmeldungTeamsNotDoneAtStart(AcceptanceTester $I, \Page\Acceptance\Login $IHelper)
    {
        $IHelper->amLoggedInAs(VereinsmeldeUserTestdata::getUser('email'), VereinsmeldeUserTestdata::getPassword());
        $I->amOnPage( \yii\helpers\Url::toRoute(['/vereinsmeldung/index']));
        $I->waitForElement("#vereinsmeldung-uebersicht");
        //kein success beim vereinskontakt, weil noch nicht eingegeben
        $I->seeElement('#vereinsmeldemodul-2 .text-danger');
                
    }

    public function vereinsmeldungOpenTeams(AcceptanceTester $I, \Page\Acceptance\Login $IHelper)
    {
        $IHelper->amLoggedInAs(VereinsmeldeUserTestdata::getUser('email'), VereinsmeldeUserTestdata::getPassword());

        $item = new Page\Acceptance\CreateEditDeleteSeasondata();
        $vereinsmeldung_id = $item->getVereinsmeldungData('id');
        $I->amOnPage( \yii\helpers\Url::toRoute(['/vereinsmeldung/teams','p'=>$vereinsmeldung_id]));

        $I->waitForElement("#no-teams");
                
    }


    public function vereinsmeldungFinishWithoutAddingTeams(AcceptanceTester $I, \Page\Acceptance\Login $IHelper)
    {
        $IHelper->amLoggedInAs(VereinsmeldeUserTestdata::getUser('email'), VereinsmeldeUserTestdata::getPassword());

        $item = new Page\Acceptance\CreateEditDeleteSeasondata();
        $vereinsmeldung_id = $item->getVereinsmeldungData('id');
        $I->amOnPage( \yii\helpers\Url::toRoute(['/vereinsmeldung/teams','p'=>$vereinsmeldung_id]));

        $I->waitForElement("#no-teams");
        $I->seeElement("#finish-with-empty-teams");
        $I->click("#finish-with-empty-teams");

        $I->waitForElement("#vereinsmeldung-uebersicht");
        //kein success beim vereinskontakt, weil noch nicht eingegeben
        $I->seeElement('#vereinsmeldemodul-2 .text-danger');
                
    }

    public function vereinsmeldungAddTeam(AcceptanceTester $I, \Page\Acceptance\Login $IHelper)
    {
        $IHelper->amLoggedInAs(VereinsmeldeUserTestdata::getUser('email'), VereinsmeldeUserTestdata::getPassword());

        $item = new Page\Acceptance\CreateEditDeleteSeasondata();
        $vereinsmeldung_id = $item->getVereinsmeldungData('id');
        $I->amOnPage( \yii\helpers\Url::toRoute(['/vereinsmeldung/add-team-altersbereich','p'=>$vereinsmeldung_id]));

        //altersbereich auswählen
        $I->waitForElement("#item-1");
        $I->click('#item-2'); //Herren auswählen
        $I->click('.btn-primary'); //weiter

        //team eingeben
        $I->waitForElement("#team-new");
        $I->selectOption("#teameditform-altersklasse_id","Herren");//altersklasse
        $I->selectOption("#teameditform-liga_id","Kreisliga");//liga
        $I->fillField("#teameditform-heimspieltage", "Mo(20:00)");//heimspieltage
        $I->click('.btn-primary'); //weiter
        
        //teams-seite wieder offen und team da?
        $I->waitForElement("#item-1");

        //edit
        $I->click('#item-1'); //Herren auswählen
        $I->waitForElement("#team-edit");
        $I->selectOption("#teameditform-liga_id","1.Kreisklasse");//liga
        $I->click('.btn-primary'); //weiter

        //teams-seite wieder offen und team da?
        $I->waitForElement("#item-1");
        $I->see('1.Kreisklasse');

        //edit und löschen
        $I->click('#item-1'); //Herren auswählen
        $I->waitForElement("#team-edit");
        $I->click('.btn-danger'); //löschen

        //teams-seite wieder offen und team da?
        $I->waitForElement("#vereinsmeldung-teams");
        $I->dontSee('1.Kreisklasse');
        
    }
    
    
}
