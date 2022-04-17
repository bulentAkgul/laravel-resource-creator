<?php

return [
    'blade' => [
        'category' => 'view',
        'convention' => 'kebab',
        'extension' => 'blade.php',
        'options' => [
            'oop' => true
        ],
    ],
    'css' => [
        'category' => 'css',
        'convention' => 'kebab',
        'extension' => 'css',
        'options' => [],
    ],
    'electron' => [
        'category' => 'js',
        'convention' => 'Pascal',
        'extension' => 'js',
        'framework' => 'vue',
        'options' => [],
    ],
    'flutter' => [
        'category' => 'view',
        'convention' => 'Pascal',
        'extension' => 'dart',
        'options' => [],
    ],
    'ionic' => [
        'category' => 'view',
        'convention' => 'pascal',
        'extension' => 'vue',
        'options' => [],
        'framework' => 'vue',
    ],
    'js' => [
        'category' => 'js',
        'convention' => 'pascal',
        'extension' => 'js',
        'options' => [],
    ],
    'less' => [
        'category' => 'css',
        'convention' => 'kebab',
        'extension' => 'less',
        'options' => [],
    ],
    'next' => [
        'category' => 'view',
        'convention' => 'pascal',
        'extension' => 'jsx',
        'options' => [],
        'framework' => 'react',
    ],
    'nuxt' => [
        'category' => 'view',
        'convention' => 'pascal',
        'extension' => 'vue',
        'options' => [],
        'framework' => 'vue',
    ],
    'react' => [
        'category' => 'view',
        'convention' => 'pascal',
        'extension' => 'jsx',
        'options' => [],
    ],
    'sass' => [
        'category' => 'css',
        'convention' => 'kebab',
        'extension' => 'scss',
        'options' => [],
    ],
    'svelte' => [
        'category' => 'view',
        'convention' => 'pascal',
        'extension' => 'svelte',
        'options' => [],
    ],
    'svelteKit' => [
        'category' => 'view',
        'convention' => 'pascal',
        'extension' => 'svelte',
        'options' => [],
        'framework' => 'svelte',
    ],
    'vue' => [
        'category' => 'view',
        'convention' => 'pascal',
        'extension' => 'vue',
        'options' => [
            'store' => 'pinia',
            'code_splitting' => true,
            'composable' => true,
            'compositionAPI' => false,
            'ts' => false,
        ],
    ],
    'pinia' => [
        'framework' => 'vue',
        'extension' => 'js',
        'name_schema' => 'use{{ schema }}Store'
    ],
    'inertia' => [
        'renderables' => ['index', 'show', 'edit']
    ]
];
