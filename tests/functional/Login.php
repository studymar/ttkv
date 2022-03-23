<?php
namespace Step\Acceptance;

class Login extends \FunctionalTester
{
    
    public function loggedIn(\FunctionalTester $I)
    {
        $I->see('Login', 'h2');
        $I->fillField("#loginform-email", "test@ttkv-harburg.de");
        $I->fillField("#loginform-password", "harburg2416z");
        $I->click('Login');
        $I->amOnPage('account/home');
    }

}
