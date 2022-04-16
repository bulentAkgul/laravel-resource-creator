<?php

namespace Bakgul\ResourceCreator\Tasks;

use Bakgul\Kernel\Helpers\Arry;
use Bakgul\Kernel\Helpers\Text;

class SetRelativePath
{
    public static function _(string $from, string $to): string
    {
        [$from, $to] = self::dropFile(self::purify(self::serialize([$from, $to])));

        if (self::isTheSameFolder($from, $to)) return './';

        return str_repeat('../', count($from)) . implode('/', $to);
    }

    private static function serialize(array $paths): array
    {
        return array_map(fn ($x) => array_filter(Text::serialize($x)), $paths);
    }

    private static function purify(array $paths): array
    {
        $sames = 0;

        foreach ($paths[0] as $i => $name) {
            if ($paths[1][$i] == $name) $sames++;
            else break;
        }

        return array_map(fn ($x) => array_slice($x, $sames), $paths);
    }

    private static function dropFile(array $paths): array
    {
        return array_map(fn ($x) => str_contains($x[array_key_last($x)], '.') ? Arry::drop($x) : $x, $paths);
    }

    private static function isTheSameFolder(array $from, array $to)
    {
        return empty($from) && empty($to);
    }
}
