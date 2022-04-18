<?php

return [
    'routables' => ['index', 'store', 'create', 'show', 'edit', 'update', 'destroy'],
    'schemas' => [
        'index' => '',
        'store' => 'store',
        'create' => 'create',
        'show' => ':var',
        'edit' => ':var/edit',
        'update' => ':var/update',
        'destroy' => ':var/destroy',
    ]
];
