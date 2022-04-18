<?php

namespace Bakgul\ResourceCreator\Tasks;

use Bakgul\Kernel\Functions\ConstructPath;
use Bakgul\Kernel\Helpers\Folder;
use Bakgul\Kernel\Helpers\Path;
use Illuminate\Support\Arr;

class SetFolders
{
    public static function _(array $attr, array $map): array
    {
        return self::hasFolders($attr) ? self::set($attr, $map) : [];
    }

    private static function hasFolders(array $attr): bool
    {
        return $attr['subs'] || $attr['page_hierarchy'];
    }

    private static function set(array $attr, array $map): array
    {
        return [
            'subs' => self::subs($attr['subs'], $attr['convention']),
            'hierarchy' => self::hierarchy($attr, $map)
        ];
    }

    private static function subs(array $subs, string $convention): string
    {
        return Path::glue(Path::make($subs, $convention));
    }

    private static function hierarchy(array $attr, array $map): string
    {
        if (!$attr['page_hierarchy']) return '';
        
        return self::folders(self::base($attr, $map), self::parents($attr));
    }

    private static function base(array $attr, array $map): string
    {
        return ConstructPath::_(['attr' => $attr, 'map' => self::getValues($map)]);
    }

    private static function getValues(array $map): array
    {
        return array_filter(
            $map,
            fn ($x) => in_array($x, ['apps', 'app', 'container', 'variation']),
            ARRAY_FILTER_USE_KEY
        );
    }

    private static function parents(array $attr): array
    {
        return Path::make($attr['page_hierarchy'], $attr['convention']);
    }

    private static function folders($base, $parents): string
    {
        $folders = [];

        foreach (self::structure($base) as $path) {
            if (self::isNotFound($path, $parents)) continue;
            
            $folders = [...self::grandParents($path, $parents), ...$parents];
        }

        return Path::glue($folders);
    }

    private static function structure($base): array
    {
        return array_map(
            fn ($x) => explode('.', $x),
            array_keys(Arr::dot(Folder::tree($base)))
        );
    }

    private static function isNotFound(array $path, array $parents): bool
    {
        return array_reduce($parents, fn ($p, $c) => $p && !in_array($c, $path), true);
    }

    private static function grandParents(array $path, array $folders): array
    {
        return array_slice($path, 0, array_search($folders[0], $path));
    }
}
