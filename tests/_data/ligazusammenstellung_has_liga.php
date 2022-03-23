<?php
use \app\models\helpers\DateConverter;

$actualDateTime = DateConverter::getNow();

return [
    [
        'ligazusammenstellung_id' => '1',
        'liga_id' => '1',
        'created_at' => DateConverter::getNow(),
    ],
    [
        'ligazusammenstellung_id' => '1',
        'liga_id' => '2',
        'created_at' => DateConverter::getNow(),
    ],
    [
        'ligazusammenstellung_id' => '2',
        'liga_id' => '1',
        'created_at' => DateConverter::getNow(),
    ],
    [
        'ligazusammenstellung_id' => '2',
        'liga_id' => '2',
        'created_at' => DateConverter::getNow(),
    ],
    [
        'ligazusammenstellung_id' => '3',
        'liga_id' => '1',
        'created_at' => DateConverter::getNow(),
    ],
    [
        'ligazusammenstellung_id' => '3',
        'liga_id' => '2',
        'created_at' => DateConverter::getNow(),
    ],
];