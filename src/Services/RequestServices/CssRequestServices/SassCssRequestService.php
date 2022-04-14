<?php

namespace Bakgul\ResourceCreator\Services\RequestServices\CssRequestServices;

use Bakgul\Kernel\Helpers\Path;
use Bakgul\Kernel\Helpers\Settings;
use Bakgul\Kernel\Tasks\ConvertCase;
use Bakgul\ResourceCreator\Services\RequestServices\CssRequestService;
use Bakgul\ResourceCreator\Tasks\SetRelativePath;

class SassCssRequestService extends CssRequestService
{
    public function handle(array $request): array
    {
        $request['attr']['file'] = "{$request['map']['name']}.{$request['attr']['extension']}";

        $request['map']['forwards'] = '';
        $request['map']['uses'] = self::setUses($request['attr']);
        $request['map']['class'] = self::setClass($request['map']['name']);

        return $request;
    }

    private function setUses(array $attr)
    {
        return '@use "'
            . Path::glue([
                SetRelativePath::_($attr['path'], $this->abstractions()),
                "variables.{$attr['extension']}"
            ]) . '" as *;'
            . str_repeat(PHP_EOL, 2);
    }

    private function abstractions()
    {
        return Path::glue(array_filter([
            resource_path(),
            Settings::standalone() ? Settings::folders('shared') : '',
            Settings::folders('css'),
            Settings::folders('abstract')
        ]));
    }

    private function setClass(string $name): string
    {
        return '.' . ConvertCase::kebab($name). ' {}';
    }
}