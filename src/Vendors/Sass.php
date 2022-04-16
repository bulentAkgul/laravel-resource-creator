<?php

namespace Bakgul\ResourceCreator\Vendors;

use Bakgul\Kernel\Helpers\Path;
use Bakgul\Kernel\Helpers\Settings;
use Bakgul\Kernel\Helpers\Text;
use Bakgul\Kernel\Tasks\ConvertCase;
use Bakgul\ResourceCreator\Tasks\SetRelativePath;

class Sass
{
    public static function use(array $attr): string
    {
        return '@use "'
            . Path::glue([
                SetRelativePath::_($attr['path'], self::abstractions()),
                "variables.{$attr['extension']}"
            ]) . '" as *;'
            . str_repeat(PHP_EOL, 2);
    }

    private static function abstractions()
    {
        return Path::glue(array_filter([
            resource_path(),
            Settings::standalone() ? Settings::folders('shared') : '',
            Settings::folders('css'),
            Settings::folders('abstract')
        ]));
    }

    public static function class(string $name): string
    {
        return '.' . ConvertCase::kebab($name). ' {}';
    }

    public static function target(array $request)
    {
        return str_replace(
            Text::append($request['map']['subs'], DIRECTORY_SEPARATOR),
            '',
            $request['attr']['path']
        ) . DIRECTORY_SEPARATOR. "_index.{$request['attr']['extension']}";
    }

    public static function forward(string $name): string
    {
        return '@forward "./' . $name . '";';
    }
}