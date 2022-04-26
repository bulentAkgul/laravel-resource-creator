<?php

namespace Bakgul\ResourceCreator\Functions;

use Bakgul\Kernel\Helpers\Settings;

class IsFilesPath
{
    public static function _(string $file, string $type, string $path): bool
    {
        foreach (GetExtension::_($type)  as $ext) {
            if (str_contains($path, DIRECTORY_SEPARATOR . "{$file}.{$ext}")) {
                return true;
            }
        }

        return false;
    }
}