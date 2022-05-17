<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Variation Levels
    |--------------------------------------------------------------------------
    |
    | Low-level variations have neither store nor route.
    | Medium-level variations have stores but don't have routes.
    | High-level variations have both store and route.
    |
    */
    'low' => ['component', 'composite'],
    'medium' => ['module'],
    'high' => ['section', 'page']
];
