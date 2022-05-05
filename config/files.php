<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Resource Files from Resource Creator
    |--------------------------------------------------------------------------
    |
    | These are the file group types that can be created by "create:resource"
    | command. The details of the creating files are in the "resources" array,
    | they will be chosed based on the app passed in the command. For example,
    | when you create a view file in admin app, the file type will be "Vue"
    | because admin app type is Vue. The main logic of the other parts are
    | already explained in the previous comment block. We have one extra field
    | here which is "roles." You can pass the value of role as "extra."
    |
    */
    'view' => [
        'family' => 'resources',
        'name_schema' => '{{ prefix }}{{ name }}{{ task }}{{ wrapper }}',
        'path_schema' => '{{ apps }}{{ app }}{{ container }}{{ variation }}{{ folder }}{{ subs }}',
        'tasks' => ['', 'index', 'store', 'update', 'destroy'],
        'variations' => ['component', 'composite', 'module', 'section', 'page'],
        'roles' => ['', 'livewire'],
        'name_count' => 'X',
        'pairs' => ['css', 'js'],
    ],
    'js' => [
        'family' => 'resources',
        'name_schema' => '{{ prefix }}{{ name }}{{ task }}{{ wrapper }}',
        'path_schema' => '{{ apps }}{{ app }}{{ container }}{{ role }}{{ variation }}{{ folder }}{{ subs }}',
        'tasks' => ['', 'index', 'store', 'update', 'destroy'],
        'variations' => ['component', 'composite', 'module', 'section', 'page'],
        'roles' => ['', 'class', 'store', 'route'],
        'name_count' => 'X',
        'pairs' => [''],
    ],
    'css' => [
        'family' => 'resources',
        'name_schema' => '{{ prefix }}{{ name }}{{ task }}{{ wrapper }}',
        'path_schema' => '{{ apps }}{{ app }}{{ container }}{{ variation }}{{ folder }}{{ subs }}',
        'tasks' => ['', 'index', 'store', 'update', 'destroy'],
        'variations' => ['component', 'composite', 'module', 'section', 'page'],
        'roles' => [''],
        'name_count' => 'X',
        'pairs' => [''],
    ],
];
