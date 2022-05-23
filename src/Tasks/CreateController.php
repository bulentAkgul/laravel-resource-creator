<?php

namespace Bakgul\ResourceCreator\Tasks;

use Bakgul\Kernel\Functions\CreateFileRequest;
use Bakgul\Kernel\Helpers\Arry;
use Bakgul\Kernel\Helpers\Settings;
use Bakgul\Kernel\Tasks\SimulateArtisanCall;
use Bakgul\ResourceCreator\Functions\SetViewArgument;

class CreateController
{
    public static function _(array $request)
    {
        if (self::isNotCreatable($request)) return;

        (new SimulateArtisanCall)(CreateFileRequest::_([
            'name' => $request['attr']['command']['name'],
            'type' => self::setType($request),
            'package' => $request['attr']['package'],
            'app' => $request['attr']['app'],
            'views' => SetViewArgument::_($request)
        ]));
    }

    private static function isNotCreatable(array $request): bool
    {
        return self::hasNoFileCreator()
            || self::isNotHighLevel($request)
            || self::hasNoController($request)
            || self::isLivewire($request);
    }

    private static function hasNoFileCreator()
    {
        return !class_exists('\Bakgul\FileCreator\FileCreatorServiceProvider');
    }

    private static function isNotHighLevel($request)
    {
        return Arry::hasNot($request['attr']['variation'], Settings::get('levels.high'), 'value');
    }

    private static function hasNoController($request)
    {
        $ephc = Settings::main('each_page_has_controller');

        return match (true) {
            $request['attr']['variation'] == 'page' => !$ephc,
            Settings::main('tasks_as_section') => true,
            $request['attr']['taskless'] => true,
            default => !$ephc
        };
    }

    private static function isLivewire($request)
    {
        return $request['attr']['extra'] == 'livewire';
    }

    private static function setType(array $request)
    {
        return implode(Settings::seperators('modifier'), array_filter(
            ['controller', $request['attr']['app_type'] == 'blade' ? '' : 'api']
        ));
    }
}
