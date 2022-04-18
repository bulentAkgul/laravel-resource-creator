<?php

namespace Bakgul\ResourceCreator\Vendors;

use Bakgul\Kernel\Helpers\Path;
use Bakgul\Kernel\Helpers\Settings;
use Bakgul\Kernel\Helpers\Text;
use Bakgul\Kernel\Tasks\ConvertCase;
use Bakgul\ResourceCreator\Tasks\SetRelativePath;

class Sass
{
    public function vendor(): string
    {
        return 'sass';
    }

    public function stub(): string
    {
        return 'css.stub';
    }

    public function class(string $name): string
    {
        return '.' . ConvertCase::kebab($name) . ' {}';
    }

    public function forward(string $name): string
    {
        return '@forward "./' . $name . '";';
    }

    public function use(array $attr): string
    {
        $abstractions = $this->abstractions();

        if (!$abstractions) return '';

        $file = Path::glue([$abstractions, "variables.{$attr['extension']}"]);

        if (!file_exists($file)) return '';

        return '@use "' . Path::glue([
            SetRelativePath::_($attr['path'], $abstractions),
            "variables.{$attr['extension']}"
        ]) . '" as *;' . str_repeat(PHP_EOL, 2);
    }

    public function target(array $request)
    {
        return str_replace(
            Text::append($request['map']['subs'], DIRECTORY_SEPARATOR),
            '',
            $request['attr']['path']
        ) . DIRECTORY_SEPARATOR . "_index.{$request['attr']['extension']}";
    }

    private function abstractions(): string
    {
        $path = Path::glue(array_filter([
            resource_path(),
            Settings::standalone() ? Settings::folders('shared') : '',
            Settings::folders('css'),
            Settings::folders('abstract')
        ]));

        return file_exists($path) ? $path : '';
    }
}
