<?php
return [
    'Usermanager' => [
        'id' => '1',
        'name' => 'Usermanager',
        'rightgroup_id' => '3',
        'sort' => '1',
        'route' => 'usermanager/index',
    ],
    'Rolemanager' => [
        'id' => '2',
        'name' => 'Rolemanager',
        'rightgroup_id' => '3',
        'sort' => '2',
        'route' => 'rolemanager/index',
    ],
    'VereinsmeldungAbgeben' => [
        'id' => '3',
        'name' => 'Vereinsmeldung abgeben',
        'rightgroup_id' => '1',
        'sort' => '1',
        'route' => 'vereinsmeldung/index',
    ],
    'VereinskontaktePflegen' => [
        'id' => '4',
        'name' => 'Vereinskontakte pflegen',
        'rightgroup_id' => '1',
        'sort' => '2',
        'route' => 'vereinskontakte/index',
    ],
    'VereinsmeldungenVerwalten' => [
        'id' => '5',
        'name' => 'Vereinsmeldungen verwalten',
        'rightgroup_id' => '2',
        'sort' => '1',
        'route' => 'vereinsmeldung/control',
    ],
];