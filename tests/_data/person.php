<?php
use \app\models\helpers\DateConverter;

$actualDateTime = DateConverter::getNow();

return [
    [
        'id' => '1',
        'firstname' => 'Max',
        'lastname' => 'Mustermann',
        'email' => 'abc@ttkv-harburg.de',
        'phone' => '012345',
        'street' => 'abc-straße',
        'zip' => '21244',
        'city' => 'Buchholz',
        'created_at' => $actualDateTime,
    ],
];