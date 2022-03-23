<?php
use \app\models\helpers\DateConverter;

$actualDateTime = DateConverter::getNow();

return [
    [
        'id' => '1',
        'name' => 'Verinsvorstand',
    ],
    [
        'id' => '2',
        'name' => 'Kreisvorstand',
    ],
    [
        'id' => '3',
        'name' => 'Kassenprüfer',
    ],
    [
        'id' => '4',
        'name' => 'Kreisjugendausschuss',
    ],
];