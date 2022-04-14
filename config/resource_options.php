<?php

return [
    'levels' => [
        'low' => ['component', 'composite'],
        'medium' => ['module'],
        'high' => ['section', 'page']
    ],
    'each_page_has_controller' => false,
    'share_low_levels_betwen_apps' => true,
    'use_prefix' => true,
    'section_parents' => ['page', 'class', 'store'],
    'css' => 'sass',
];