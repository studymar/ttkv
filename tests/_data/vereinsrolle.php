<?php
use \app\models\helpers\DateConverter;

$actualDateTime = DateConverter::getNow();

return [
    [
        'id' => '1',
        'funktionsgruppe_id' => '1',
        'name' => 'Abteilungsleiter',
        'shortname' => 'Abtl.',
    ],
];