<?php

namespace Bakgul\ResourceCreator\Tasks;

use Bakgul\FileContent\Helpers\Content;
use Bakgul\FileContent\Tasks\GetCodeLine;
use Bakgul\FileContent\Tasks\WriteToFile;
use Bakgul\Kernel\Helpers\Arry;
use Bakgul\Kernel\Functions\SetLineSpecs;
use Illuminate\Support\Str;

class CombineImports
{
    private static $content;
    private static $start;
    private static $end;
    private static $imports;

    public static function _(array $specs, string $path): void
    {
        self::getContent($path);

        self::getImports($specs);

        self::purify();

        self::regenerate();

        self::write($path);
    }

    private static function getContent(string $path): void
    {
        self::$content = Content::read($path, purify: false);
    }

    private static function getImports(array $specs): void
    {
        [self::$start, self::$end, self::$imports] = GetCodeLine::_(self::$content, SetLineSpecs::_($specs));
    }

    private static function purify(): void
    {
        self::$content = Content::purify(self::$content, self::$start, self::$end);
    }

    private static function regenerate()
    {
        self::$content = Content::regenerate(self::$content, self::$start, self::combine());
    }

    private static function write(string $path)
    {
        WriteToFile::_(self::$content, $path);
    }

    private static function combine(): array
    {
        $combined = [];

        foreach (self::createGroups(self::$imports) as $file => $group) {
            $combined[] = 'import ' . self::extendParts($group) . " from {$file}";
        }

        return $combined;
    }

    private static function extendParts(array $group)
    {
        $group = array_reduce($group, fn ($p, $c) => self::addPart($p, $c), []);

        return (count($group) > 1 ? '{ ' : '') . implode(', ', $group) . (count($group) > 1 ? ' }' : '');
    }

    private static function addPart(array $carry, string $current)
    {
        return array_merge($carry, [trim(Str::between($current, 'import', 'from'))]);
    }

    private static function createGroups(array $imports): array
    {
        $groups = [];

        foreach ($imports as $import) {
            $key = trim(Str::between($import, 'from', ';'));

            if (!Arry::has($key, $groups)) $groups[$key] = [];

            $groups[$key][] = $import;
        }

        return $groups;
    }
}
