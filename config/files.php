<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Resource Files from Resource Creator
    |--------------------------------------------------------------------------
    |
    | This is the list of file-group types created by the "create:resource"
    | command. The details of the creatable types are in the "resources"
    | array. They will be chosen based on the app passed in the command.
    | For example, when creating a view file in the admin app, the file
    | type will be "Vue" because the admin app type is Vue. The main logic
    | of the other parts is already explained in the previous comment block.
    | As you can see, 'tasks' are empty by default. Their values will be
    | got from 'main.tasks_have_views' array. You can overwrite tasks by
    | setting them here. We have one extra field here, which is "roles."
    |
    */
    'view' => [
        'family' => 'resources',
        'name_schema' => '{{ prefix }}{{ name }}{{ task }}{{ wrapper }}',
        'path_schema' => '{{ apps }}{{ app }}{{ container }}{{ variation }}{{ folder }}{{ subs }}',
        'tasks' => [],
        'variations' => ['component', 'composite', 'module', 'section', 'page'],
        'roles' => ['', 'livewire'],
        'name_count' => 'X',
        'pairs' => ['css', 'js'],
    ],
    'js' => [
        'family' => 'resources',
        'name_schema' => '{{ prefix }}{{ name }}{{ task }}{{ wrapper }}',
        'path_schema' => '{{ apps }}{{ app }}{{ container }}{{ role }}{{ variation }}{{ folder }}{{ subs }}',
        'tasks' => [],
        'variations' => ['component', 'composite', 'module', 'section', 'page'],
        'roles' => ['', 'class', 'store', 'route'],
        'name_count' => 'X',
        'pairs' => [''],
    ],
    'css' => [
        'family' => 'resources',
        'name_schema' => '{{ prefix }}{{ name }}{{ task }}{{ wrapper }}',
        'path_schema' => '{{ apps }}{{ app }}{{ container }}{{ variation }}{{ folder }}{{ subs }}',
        'tasks' => [],
        'variations' => ['component', 'composite', 'module', 'section', 'page'],
        'roles' => [''],
        'name_count' => 'X',
        'pairs' => [''],
    ],
];
