<?php

/*
 * Users for Fixtures
 */

namespace Page\Acceptance;

use \app\models\helpers\DateConverter;



/**
 * Description of Fixturedata
 *
 * @author Mark Worthmann
 */
class CreateEditDeleteSeasondata {
    
    
    
    public function getSeasonData($attribute = false){
        $item = [
                'id' => '1',
                'name' => '2022',
                'created_at' => DateConverter::getNow(),
                'active' => '1',
        ];
        
        if($attribute && isset($item[$attribute]))
            return $item[$attribute];
        return $item;
    }
    
    public function getSeasonHasVereinsmeldemodulData($attribute = false){
        $item = [
            [
                'season_id' => '1',
                'vereinsmeldemodul_id' => '1',
                'sort' => '1',
            ],
            [
                'season_id' => '1',
                'vereinsmeldemodul_id' => '2',
                'sort' => '2',
            ],
            [
                'season_id' => '1',
                'vereinsmeldemodul_id' => '3',
                'sort' => '3',
            ],
            [
                'season_id' => '1',
                'vereinsmeldemodul_id' => '4',
                'sort' => '4',
            ],
            [
                'season_id' => '1',
                'vereinsmeldemodul_id' => '5',
                'sort' => '5',
            ],
            [
                'season_id' => '1',
                'vereinsmeldemodul_id' => '6',
                'sort' => '6',
            ],
        ];        
        
        if($attribute && isset($item[$attribute]))
            return $item[$attribute];
        return $item;
    }

    public function getVereinsmeldungData($attribute = false){
        $item = [
            [
                'id' => '1',
                'season_id' => '1',
                'vereins_id' => '27',
                'status' => \app\models\vereinsmeldung\Vereinsmeldung::$STATUS_OPEN,
                'created_at' => DateConverter::getNow(),
            ],
        ];
        if($attribute){
            foreach($item as $anItem){
                return $anItem[$attribute];
            }
        }
        return $item;
                
    }    

    
    public function getVereinsmeldungKontakteData($attribute = false){
        $item = [
            [
                'id' => '1',
                'vereinsmeldung_id' => '1',
                'created_at' => DateConverter::getNow(),
            ]
        ];
        return $item;
                
    }    
    
    public function getVereinskontakteData($attribute = false){
        $item = [
//            [
//                'id' => '1',
//                'vereinsmeldung_id' => '1',
//                'created_at' => DateConverter::getNow(),
//            ]
        ];
        return $item;
                
    }    

    public function getVereinsmeldungTeamsData($attribute = false){
        $item = [
            [
                'id' => '1',
                'vereinsmeldung_id' => '1',
                'created_at' => DateConverter::getNow(),
                'noteamsflag'  => '0',
            ],
        ];        
        
        if($attribute && isset($item[$attribute]))
            return $item[$attribute];
        return $item;
                
    }    

    
}
