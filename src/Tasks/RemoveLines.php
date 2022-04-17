<?php

namespace Bakgul\ResourceCreator\Tasks;

use Bakgul\Kernel\Helpers\Path;
use Illuminate\Support\Str;

class RemoveLines
{
    public static function byStr(array|string $data, $from = '', $to = '', bool $removeCodes = true): void
    {
        $path = is_array($data) ? Path::glue([$data['path'], $data['file']]) : $data;

        $content = file_get_contents($path);

        file_put_contents($path, str_replace(array_filter([
            $removeCodes ? Str::between($content, $from, $to) : '', $from, $to
        ]), '', $content));
    }

    public static function byIndex()
    {
    }
}
