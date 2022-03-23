<?php
use \app\models\helpers\DateConverter;

$actualDateTime = DateConverter::getNow();

return [
    [
        'id' => '1',
        'name' => 'Kreisliga',
        'inactive' => '0',
        'sort' => '1',
    ],
    [
        'id' => '2',
        'name' => '1.Kreisklasse',
        'inactive' => '0',
        'sort' => '2',
    ],
];