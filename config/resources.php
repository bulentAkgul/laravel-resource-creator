<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Resources
    |--------------------------------------------------------------------------
    |
    | This is the List of files and frameworks to create resources.
    | Any item whose category is the view, can be an app type, which is set
    | into "apps" array. The options of items can be changed, but other than
    | this list isn't very customizable. Some settings worth to mention:
    | 
    | oop: if it's true, vanilla JS file will be classes.
    | js.extension: make it "ts" if you want to work with TypeScript
    | sass.extension: it can be 'scss' or 'sass'
    | vue.options.store: it can be 'pinia' or 'vuex',
    | vue.compositionAPI: if it's true script setup will be used.
    | code_splitting: when it's true, the components will be loaded lazyly.
    | 
    |
    */
    'blade' => [
        'category' => 'view',
        'convention' => 'kebab',
        'extension' => 'blade.php',
        'options' => [
            'oop' => true,
            'livewire' => true,
            'router' => 'laravel'
        ],
    ],
    'css' => [
        'category' => 'css',
        'convention' => 'kebab',
        'extension' => 'css',
        'options' => [],
    ],
    'js' => [
        'category' => 'js',
        'convention' => 'pascal',
        'extension' => 'js',
        'options' => [
            'oop' => true,
            'extensions' => ['js', 'ts']
        ],
    ],
    'nuxt' => [
        'category' => 'view',
        'convention' => 'pascal',
        'extension' => 'vue',
        'framework' => 'vue',
        'options' => [],
    ],
    'sass' => [
        'category' => 'css',
        'convention' => 'kebab',
        'extension' => 'scss',
        'options' => [],
    ],
    'vue' => [
        'category' => 'view',
        'convention' => 'pascal',
        'extension' => 'vue',
        'options' => [
            'store' => 'pinia',
            'code_splitting' => false,
            'compositionAPI' => true,
            'router' => 'vue-router',
            'ts' => false,
        ],
    ],
    'pinia' => [
        'framework' => 'vue',
        'extension' => 'js',
        'name_schema' => 'use{{ schema }}Store',
        'maps' => ['computeds' => ['State'], 'methods' => ['Actions']],
    ],
    'vuex' => [
        'framework' => 'vue',
        'extension' => 'js',
        'maps' => ['computeds' => ['State', 'Getters'], 'methods' => ['Actions']],
    ],
    'inertia' => [
        'renderables' => ['index', 'show', 'edit'],
    ],
];
