<?php

return [
    'levels' => [
        'low' => ['component', 'composite'],
        'medium' => ['module'],
        'high' => ['section', 'page']
    ],
    'each_page_has_controller' => true,
    'share_low_levels_between_apps' => true,
    'use_prefix' => true,
    'section_parents' => ['page', 'class', 'store'],
    'css' => 'sass',
    'tasks_as_sections' => false,
];
