<?php
use \app\models\helpers\DateConverter;

$actualDateTime = DateConverter::getNow();

return [
    [
        'id' => '1',
        'name' => 'Damen',
        'sort' => '1',
        'altersbereich_id' => '1',
    ],
    [
        'id' => '2',
        'name' => 'Herren',
        'sort' => '1',
        'altersbereich_id' => '2',
    ],
    [
        'id' => '3',
        'name' => 'Jungen 19',
        'sort' => '1',
        'altersbereich_id' => '3',
    ],
    [
        'id' => '4',
        'name' => 'Jungen 18',
        'sort' => '2',
        'altersbereich_id' => '3',
    ],
    [
        'id' => '5',
        'name' => 'Mädchen',
        'sort' => '1',
        'altersbereich_id' => '3',
    ],
];