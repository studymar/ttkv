<?php
use \app\models\helpers\DateConverter;

$actualDateTime = DateConverter::getNow();

return [
    [
        'id' => '1',
        'name' => 'Herren Ligen',
        'altersbereich_id' => '1',
    ],
    [
        'id' => '2',
        'name' => 'Damen Ligen',
        'altersbereich_id' => '2',
    ],
    [
        'id' => '3',
        'name' => 'Jugend Ligen',
        'altersbereich_id' => '3',
    ],
];