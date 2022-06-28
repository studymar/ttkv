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
class EditdataUserTestdata extends UserTestdata {

    
    public static function getUser($attribute = false){
        $item = parent::getUser();
        $item['id']         = "13";
        $item['firstname']  = "Editdata";
        $item['lastname']   = "Editdata";
        $item['email']      = "editdata@ttkv-harburg.de";
        
        if($attribute && isset($item[$attribute]))
            return $item[$attribute];
        return $item;
    }
    
    public static function getPassword(){
        return parent::$password;
    }
    
    
}
