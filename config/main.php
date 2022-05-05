<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Main From Resource Creator
    |--------------------------------------------------------------------------
    |
    | The settings to controll some behaviours of resource creator.
    | css accepts one of 'css', 'sass' and 'tailwind.' The settings of 
    | the extension of sass is in "resources" array. If you set Tailwind,
    | no CSS file will be generated.
    |
    | When a low level resource is created, instead of storing it in the
    | app's folder, we will put it into the common folder to share it
    | among the apps. This feature has implemented to some extent.
    |
    | tasks_as_sections is a very important one. When we create a page 
    | with tasks, if this setting is true, those tasks will be created
    | as sections. So, we will have a page root, and section files to 
    | display inside the page. Section routes and stores will be the
    | children of the page's route and store. When we create a page 
    | with tasks, if this setting is false, we won't have any page
    | root, and each task will be a page.
    |  
    */
    'css' => 'sass',
    'each_page_has_controller' => true,
    'share_low_levels_between_apps' => true,
    'tasks_as_sections' => false,
    'use_prefix' => true,
];
