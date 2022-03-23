<?php
use \app\models\helpers\DateConverter;

$actualDateTime = DateConverter::getNow();

return [
    [
        'id' => '1',
        'name' => 'Damen',
        'askweeks' => '0',
        'askpokal' => '1',
    ],
    [
        'id' => '2',
        'name' => 'Herren',
        'askweeks' => '0',
        'askpokal' => '1',
    ],
    [
        'id' => '3',
        'name' => 'Jugend',
        'askweeks' => '1',
        'askpokal' => '0',
    ],
];