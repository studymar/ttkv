<?php
use \app\models\helpers\DateConverter;
use Page\Acceptance\Seasondata;

$actualDateTime = DateConverter::getNow();
return Seasondata::getSeason();

//return  [
//            [
//                'id' => '0',
//                'name' => '2022',
//                'created_at' => DateConverter::getNow(),
//                'active' => '1',
//            ],
//        ];
