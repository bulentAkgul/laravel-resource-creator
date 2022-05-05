<?php

namespace Bakgul\ResourceCreator\Tasks;

use Bakgul\Kernel\Helpers\Arry;
use Bakgul\Kernel\Helpers\Settings;

class ModifyFileList
{
    private static $convertedList = [];

    public static function _(array $list)
    {
        if (self::isNotModifyable()) return $list;

        foreach (Arry::group($list, 'type') as $files) {
            self::convert($files);
        }

        return self::$convertedList;
    }

    private static function isNotModifyable(): bool
    {
        return Settings::main('tasks_as_sections');
    }

    private static function convert($files)
    {
        if (self::hasNoModifyableTypes($files)) {
            self::$convertedList = [...self::$convertedList, ...$files];
            return;
        }

        foreach ($files as $file) {
            if ($file['variation'] == 'page') continue;

            self::$convertedList[] = self::modify($file);
        }
    }

    private static function hasNoModifyableTypes($files)
    {
        return !Arry::find($files, 'page', 'variation')
            || !Arry::find($files, 'section', 'variation');
    }

    private static function modify(array $file): array
    {
        return $file['variation'] == 'section' ? [
            ...$file,
            'variation' => 'page',
            'wrapper' => $file['name'],
            'name' => $file['task'],
            'task' => '',
        ] : $file;
    }
}
