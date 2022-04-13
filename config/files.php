<?php

return [
    'view' => [
        'family' => 'resources',
        'path_schema' => '{{ apps }}{{ app }}{{ container }}{{ variation }}{{ folder }}{{ subs }}',
        'tasks' => ['', 'index', 'store', 'update', 'destroy'],
        'variations' => ['component', 'composite', 'module', 'section', 'page'],
        'roles' => [''],
        'name_count' => 'X',
        'pairs' => ['css', 'js'],
    ],
    'js' => [
        'family' => 'resources',
        'path_schema' => '{{ apps }}{{ app }}{{ container }}{{ role }}{{ variation }}{{ folder }}{{ subs }}',
        'tasks' => ['', 'index', 'store', 'update', 'destroy'],
        'variations' => ['component', 'composite', 'module', 'section', 'page'],
        'roles' => ['', 'class', 'store', 'route'],
        'name_count' => 'X',
        'pairs' => [''],
    ],
    'css' => [
        'family' => 'resources',
        'path_schema' => '{{ apps }}{{ app }}{{ container }}{{ variation }}{{ folder }}{{ subs }}',
        'tasks' => ['', 'index', 'store', 'update', 'destroy'],
        'variations' => ['component', 'composite', 'module', 'section', 'page'],
        'roles' => [''],
        'name_count' => 'X',
        'pairs' => [''],
    ],
];
