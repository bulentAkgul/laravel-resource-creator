<?php

namespace Bakgul\ResourceCreator\Tasks;

class SetCase
{
    public static function _(array $attr): string
    {
        return match (true) {
            self::forceKebab($attr) => 'kebab',
            default => $attr['convention']
        };
    }

    private static function forceKebab($attr): bool
    {
        return $attr['app_type'] == 'nuxt' && in_array($attr['variation'], ['page', 'section']);
    }
}