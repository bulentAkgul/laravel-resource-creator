<?php

namespace Bakgul\ResourceCreator\Tasks;

use Bakgul\Kernel\Functions\CreateFileRequest;
use Bakgul\Kernel\Helpers\Settings;
use Bakgul\Kernel\Tasks\SimulateArtisanCall;

class CreateComponentClass
{
    public static function _(array $request)
    {
        if (self::hasNoComponentClass($request)) return;

        (new SimulateArtisanCall)(CreateFileRequest::_([
            'name' => self::setName($request),
            'type' => 'component',
            'package' => $request['attr']['package'],
            'app' => $request['attr']['app'],
        ]));
    }

    private static function hasNoComponentClass($request)
    {
        if (self::isClassableBlade($request)) return !$request['attr']['class'];

        return !$request['attr']['class']
            || in_array($request['attr']['variation'], ['component', 'section'])
            || $request['attr']['variation'] && !Settings::main('tasks_as_section');
    }

    private static function isClassableBlade($request)
    {
        return $request['attr']['app_type'] == 'blade'
            && in_array($request['attr']['variation'], ['root', 'page']);
    }

    private static function setName($request)
    {
        return $request['map']['variation']
            . Settings::seperators('folder')
            . str_replace('.blade.php', '', $request['attr']['file']);
    }
}
