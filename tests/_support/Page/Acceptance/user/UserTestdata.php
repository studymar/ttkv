<?php

/*
 * Users for Fixtures
 */

namespace Page\Acceptance\user;

use \app\models\helpers\DateConverter;



/**
 * Description of UserTestdata
 *
 * @author Mark Worthmann
 */
class UserTestdata {
    public static $password = "test123";
    
    public static function getUser($attribute = false){
        $item = [
            'id' => '12',
            'firstname' => 'Test',
            'lastname' => 'Tester',
            'email' => 'test@ttkv-harburg.de',
            'password' => '$2y$10$bNyOi9GtYMeWeLLS5VWP1O34qiBbtj7ihOeKNeca9vgQIIUdBra5i',
            'created' => DateConverter::getNow(),
            'role_id' => '1',
            'vereins_id' => '27',
            'is_validated' => '1',
            'validationtoken' => null,
            'lastlogindate' => null,
            'token' => null,
            'passwordforgottentoken' => null,
            'passwordforgottendate' => null,
            'locked' => null,
            'lockeddate' => null,
        ];
        
        if($attribute && isset($item[$attribute]))
            return $item[$attribute];
        return $item;
    }
    
    public static function getPassword(){
        return self::$password;
    }
    
    
}
