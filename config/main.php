<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Main From Resource Creator
    |--------------------------------------------------------------------------
    |
    | These settings control some behaviors of the resource creator.
    | 
    | 'css' accepts one of 'css,' 'sass,' and 'tailwind.' The setting
    | of the extension of sass is in the "resources" array. If you set
    | Tailwind, no CSS file will be generated.
    | 
    | When a low-level resource is created, we will put it into the
    | common folder instead of storing it in the app's folder to share
    | it among the apps. This feature has been implemented to some extent.
    | 
    | tasks_as_sections is a very important one. When we create a page
    | with tasks, those tasks will be created as sections if this setting
    | is true. So, we will have a page root and section files to display
    | inside the page. The children of the page's route and the store will
    | be section routes and stores. When we create a page with tasks,
    | if this setting is false, we won't have any page root, and each
    | task will be a page.
    |  
    */
    'css' => 'sass',
    'each_page_has_controller' => true,
    'share_low_levels_between_apps' => true,
    'tasks_as_sections' => false,
    'use_prefix' => true,
];
