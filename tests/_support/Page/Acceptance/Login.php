<?php
namespace Page\Acceptance;

class Login
{
    /**
     * @var AcceptanceTester
     */
    protected $tester;
    public $waitTime = 4;

    public $AdminUserID = 5;
    public $AdminUserName = "Admin";
    public $AdminUserEmail = "admin@ttkv-harburg.de";
    public $AdminUserPassword = "test123";

    public $StandardUserID = 7;    
    public $StandardUserName = "Tester";
    public $StandardUserFirstname   = "Test";
    public $StandardUserLastname    = "Tester";

    public $MydataUserFirstname  = "Mydata";
    public $MydataUserLastname  = "Mydata";
    public $MydataUserEmail = "mydata@ttkv-harburg.de";
    public $MydataUserPassword = "test123";
    
    public $EditVereinUserID = 6;    
    public $EditVereinUserName = "EditVerein";

    public $LoginUserEmail = "login@ttkv-harburg.de";
    public $LoginUserPassword = "test123";
    public $LoginLockedUserEmail = "locked@ttkv-harburg.de";
    public $LoginLockedUserPassword = "test123";
    public $LoginUnvalidatedUserEmail = "unvalidated@ttkv-harburg.de";
    public $LoginUnvalidatedUserPassword = "test123";
    
    public $ResetPasswortUserForgottenToken = "";
    
    public $VereinsmeldeUserEmail  = "vereinsmeldung@ttkv-harburg.de";
    public $VereinsmeldeUserPassword = "test123";
    
    public static $URL = '/account/index';
    
    
    // we inject AcceptanceTester into our class
    public function __construct(\AcceptanceTester $I)
    {
        $this->tester = $I;
    }    
    
    public function amLoggedInAsStandard()
    {
        $I = $this->tester;
        
        $I->amOnPage( \yii\helpers\Url::toRoute([self::$URL]));
        $I->see('Login', 'h2');
        $I->fillField("#loginform-email", "test@ttkv-harburg.de");
        $I->fillField("#loginform-password", "harburg2416z");
        $I->click('Login');
        $I->waitForElement('#account-home-list');
    }

    public function amLoggedInAsAdmin()
    {
        $I = $this->tester;
        
        $I->amOnPage( \yii\helpers\Url::toRoute([self::$URL]));
        //$I->see('Login', 'h2');
        $I->fillField("#loginform-email", $this->AdminUserEmail);
        $I->fillField("#loginform-password", $this->AdminUserPassword);
        $I->click('Login');
        $I->waitForElement('#account-home-list');
    }

    public function amLoggedInAsMyDataUser()
    {
        $I = $this->tester;
        
        $I->amOnPage( \yii\helpers\Url::toRoute([self::$URL]));
        //$I->see('Login', 'h2');
        $I->fillField("#loginform-email", $this->MydataUserEmail);
        $I->fillField("#loginform-password", $this->MydataUserPassword);
        $I->click('Login');
        $I->waitForElement('#account-home-list');
    }

    public function amLoggedInAs($email, $password)
    {
        $I = $this->tester;
        
        $I->amOnPage( \yii\helpers\Url::toRoute([self::$URL]));
        //$I->see('Login', 'h2');
        $I->fillField("#loginform-email", $email);
        $I->fillField("#loginform-password", $password);
        $I->click('Login');
        $I->waitForElement('#account-home-list');
        
    }

    
}
