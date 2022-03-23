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
class Fixturedata {
    
    public static function getFixtures(){
        $item = [
            'vereine' => [
                'class' => \app\tests\fixtures\VereinFixture::class,
                'dataFile' => codecept_data_dir() . 'verein.php'
            ],
            'roles' => [
                'class' => \app\tests\fixtures\RoleFixture::class,
                'dataFile' => codecept_data_dir() . 'role.php'
            ],
            'rights' => [
                'class' => \app\tests\fixtures\RightFixture::class,
                'dataFile' => codecept_data_dir() . 'right.php'
            ],
            'roleHasRight' => [
                'class' => \app\tests\fixtures\RoleHasRightFixture::class,
                'dataFile' => codecept_data_dir() . 'role_has_right.php'
            ],
            'rightgroups' => [
                'class' => \app\tests\fixtures\RightgroupFixture::class,
                'dataFile' => codecept_data_dir() . 'rightgroup.php'
            ],
            'users' => [
                'class' => \app\tests\fixtures\UserFixture::class,
                'dataFile' => codecept_data_dir() . 'user.php'
            ],
            'season' => [
                'class' => \app\tests\fixtures\SeasonFixture::class,
                'dataFile' => codecept_data_dir() . 'season.php'
            ],
            'vereinsmeldemodul' => [
                'class' => \app\tests\fixtures\VereinsmeldemodulFixture::class,
                'dataFile' => codecept_data_dir() . 'vereinsmeldemodul.php'
            ],
            'vereinsmeldung' => [
                'class' => \app\tests\fixtures\VereinsmeldungFixture::class,
                'dataFile' => codecept_data_dir() . 'vereinsmeldung.php'
            ],
            'season_has_vereinsmeldemodul' => [
                'class' => \app\tests\fixtures\SeasonHasVereinsmeldemodulFixture::class,
                'dataFile' => codecept_data_dir() . 'season_has_vereinsmeldemodul.php'
            ],
            'vereinsmeldung_kontakte' => [
                'class' => \app\tests\fixtures\VereinsmeldungKontakteFixture::class,
                'dataFile' => codecept_data_dir() . 'vereinsmeldung_kontakte.php'
            ],
            'vereinskontakt' => [
                'class' => \app\tests\fixtures\VereinskontaktFixture::class,
                'dataFile' => codecept_data_dir() . 'vereinskontakt.php'
            ],
            'vereinsrolle' => [
                'class' => \app\tests\fixtures\VereinsrolleFixture::class,
                'dataFile' => codecept_data_dir() . 'vereinsrolle.php'
            ],
            'funktionsgruppe' => [
                'class' => \app\tests\fixtures\FunktionsgruppeFixture::class,
                'dataFile' => codecept_data_dir() . 'funktionsgruppe.php'
            ],
            'person' => [
                'class' => \app\tests\fixtures\PersonFixture::class,
                'dataFile' => codecept_data_dir() . 'person.php'
            ],
            'altersbereich' => [
                'class' => \app\tests\fixtures\VereinsmeldungKontakteFixture::class,
                'dataFile' => codecept_data_dir() . 'altersbereich.php'
            ],
            'altersklasse' => [
                'class' => \app\tests\fixtures\VereinsmeldungKontakteFixture::class,
                'dataFile' => codecept_data_dir() . 'altersklasse.php'
            ],
            'vereinsmeldung_teams' => [
                'class' => \app\tests\fixtures\VereinsmeldungTeamsFixture::class,
                'dataFile' => codecept_data_dir() . 'vereinsmeldung_teams.php'
            ],
            'ligazusammensetzung' => [
                'class' => \app\tests\fixtures\LigazusammenstellungFixture::class,
                'dataFile' => codecept_data_dir() . 'ligazusammenstellung.php'
            ],
            'ligazusammensetzung_has_liga' => [
                'class' => \app\tests\fixtures\LigazusammenstellungHasLigaFixture::class,
                'dataFile' => codecept_data_dir() . 'ligazusammenstellung_has_liga.php'
            ],
            'liga' => [
                'class' => \app\tests\fixtures\LigaFixture::class,
                'dataFile' => codecept_data_dir() . 'liga.php'
            ],
            'team' => [
                'class' => \app\tests\fixtures\VereinsmeldungKontakteFixture::class,
                'dataFile' => codecept_data_dir() . 'team.php'
            ],
        ];        
        
        return $item;
    }
    
    
    
}
