<?php

/*
 * Users for Fixtures
 */

namespace Page\Acceptance;

use \app\models\helpers\DateConverter;
use Page\Acceptance\CreateEditDeleteSeasondata;

/**
 * Description of Fixturedata
 *
 * @author Mark Worthmann
 */
class Seasondata {
    
    public static $instances = [];
    
    /**
     * Hier die Klassen einfügen, welche als Fixtures in die DB geladen werden sollen
     * @return 
     */
    public static function getInstances(){
        self::$instances = [
            new CreateEditDeleteSeasonData(),
        ];
        return self::$instances;
    }
    
    public static function getSeason($attribute = false){
        $item = [];
        $counter = 1;
        foreach(self::getInstances() as $instance){
            $inst = $instance->getSeasonData();
            $inst['id'] = $counter++;
            $item[] = $inst;
            if($attribute)
                return $inst[$attribute];
        }
        
        return $item;
    }    
    
    
    public static function getSeasonHasVereinsmeldemodul($attribute = false){
        $item = [];
        $counter = 1;
        foreach(self::getInstances() as $instance){
            $inst = $instance->getSeasonHasVereinsmeldemodulData();
            foreach($inst as $data){
                $item[] = $data;
            }
        }
        
        return $item;
    }

    public static function getVereinsmeldung($attribute = false){
        $item = [];
        $counter = 1;
        foreach(self::getInstances() as $instance){
            $inst = $instance->getVereinsmeldungData();
            foreach($inst as $data){
                //$data['id'] = $counter++;
                $item[] = $data;
            }
        }
        
        return $item;
    }
    
    
    public static function getVereinsmeldungKontakte($attribute = false){
        $item = [];
        $counter = 1;
        foreach(self::getInstances() as $instance){
            $inst = $instance->getVereinsmeldungKontakteData();
            foreach($inst as $data){
                $data['id'] = $counter++;
                $item[] = $data;
            }
        }
        
        return $item;
    }
    
    
    public static function getVereinskontakte($attribute = false){
        $item = [];
        $counter = 1;
        foreach(self::getInstances() as $instance){
            $inst = $instance->getVereinskontakteData();
            foreach($inst as $data){
                $data['id'] = $counter++;
                $item[] = $data;
            }
        }
        
        return $item;
    }
    
    public static function getVereinsmeldemodul($attribute = false){
        $item = [
            [
                'id' => '1',
                'name' => 'Vereinskontakte eingeben',
                'url' => 'vereinsmeldung/vereinskontakte',
            ],
            [
                'id' => '2',
                'name' => 'Mannschaften eingeben',
                'url' => 'vereinsmeldung/teams',
            ],
            [
                'id' => '3',
                'name' => 'Vereinsmeldung auch in Click-tt gepflegt?',
                'url' => 'vereinsmeldung/confirmclicktt',
            ],
            [
                'id' => '4',
                'name' => 'Pokalmeldung auch in Click-tt gepflegt?',
                'url' => 'vereinsmeldung/confirmpokal',
            ],
            [
                'id' => '5',
                'name' => 'Abstimmungen für den Verbandstag',
                'url' => 'vereinsmeldung/voting',
            ],
            [
                'id' => '6',
                'name' => 'Umfragen für den Verbandstag',
                'url' => 'vereinsmeldung/survey',
            ],
        ];        
        
        if($attribute && isset($item[$attribute]))
            return $item[$attribute];
        return $item;
    }

    public static function getVereinsmeldungTeams($attribute = false){
        $item = [];
        $counter = 1;
        foreach(self::getInstances() as $instance){
            $inst = $instance->getVereinsmeldungTeamsData();
            foreach($inst as $data){
                $data['id'] = $counter++;
                $item[] = $data;
            }
        }
        
        return $item;
    }

    
}
