<?php 
namespace tests\unit\models;

use app\models\user\User;
use app\tests\fixtures\UserFixture;

class UserTest extends \Codeception\Test\Unit
{
    public function _fixtures()
    {
        return [
            'users' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'user.php'
            ],
        ];
    }
    
    /**
     * @Override
     */
    protected function _before()
    {
        // insert records in database
        //$this->tester->haveRecord('app\models\user\User', []);
        
    }

    /**
     * @Override
     */
    protected function _after()
    {
        // insert records in database
        //$this->_tearDown();
    }
    
    
    public function testFindIdentity()
    {
        expect_that($user = User::findIdentity(1));
        expect($user->role_id)->equals('1');

        expect_not(User::findIdentity(999));
    }

    /*
    public function testFindUserByAccessToken()
    {
        expect_that($user = User::findIdentityByAccessToken('100-token'));
        expect($user->username)->equals('admin');

        expect_not(User::findIdentityByAccessToken('non-existing'));        
    }

    public function testFindUserByUsername()
    {
        expect_that($user = User::findByUsername('admin'));
        expect_not(User::findByUsername('not-admin'));
    }

    /**
     * @depends testFindUserByUsername
     *
    public function testValidateUser($user)
    {
        $user = User::findByUsername('admin');
        expect_that($user->validateAuthKey('test100key'));
        expect_not($user->validateAuthKey('test102key'));

        expect_that($user->validatePassword('admin'));
        expect_not($user->validatePassword('123456'));        
    }
*/
}
