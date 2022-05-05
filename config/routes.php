<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Route Schemas
    |--------------------------------------------------------------------------
    |
    | The route schemas for different tasks. You edit the list as you need.
    | If you add a new task into the arrays of files and tasks, it can be
    | a good idea to assign a route schema to it.  
    |
    */
    'index' => '',
    'store' => 'store',
    'create' => 'create',
    'show' => ':var',
    'edit' => ':var/edit',
    'update' => ':var/update',
    'destroy' => ':var/destroy',
];
