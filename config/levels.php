<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Variation Levels
    |--------------------------------------------------------------------------
    |
    | Low level variations have neither store nor route.
    | Medium level variations have store, but don't have route.
    | High level variations have both store and route.
    |
    */
    'low' => ['component', 'composite'],
    'medium' => ['module'],
    'high' => ['section', 'page']
];
