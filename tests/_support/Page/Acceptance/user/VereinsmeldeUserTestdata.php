<?php

/*
 * Users for Fixtures
 */

namespace Page\Acceptance\user;

use Page\Acceptance\User\UserTestdata;
use \app\models\helpers\DateConverter;



/**
 * Description of UserTestdata
 *
 * @author Mark Worthmann
 */
class VereinsmeldeUserTestdata extends UserTestdata {

    
    public static function getUser($attribute = false){
        $item = parent::getUser();
        $item['id']         = "12";
        $item['firstname']  = "Vereinsmelde";
        $item['lastname']   = "User";
        $item['email']      = "vereinsmeldung@ttkv-harburg.de";
        
        if($attribute && isset($item[$attribute]))
            return $item[$attribute];
        return $item;
    }
    
    public static function getPassword(){
        return parent::$password;
    }
    
    
}
