<?php

namespace Bakgul\ResourceCreator\Tasks;

use Bakgul\Kernel\Helpers\Isolation;
use Bakgul\Kernel\Helpers\Path;
use Bakgul\Kernel\Helpers\Settings;
use Bakgul\Kernel\Helpers\Text;
use Illuminate\Support\Facades\Artisan;

class CreateBackendFiles
{
    public static function _(array $request, array $queue)
    {
        if (self::isNotCreatable($queue)) return;

        Artisan::call(self::createCommand($request));
    }

    private static function isNotCreatable(array $queue)
    {
        return !Settings::resourceOptions('each_page_has_controller')
            || !file_exists(Path::realBase(Path::glue(['vendor', 'bakgul', 'laravel-file-creator'])))
            || empty(self::creatables($queue));
    }

    private static function creatables(array $queue): array
    {
        return array_filter($queue, fn ($x) => $x['variation'] == 'page' && $x['type'] == 'view');
    }

    private static function createCommand(array $request): string
    {
        return implode(' ', array_filter([
            'create:file',
            $request['name'],
            self::setType($request),
            $request['package'],
            $request['app'],
        ]));
    }

    private static function setType(array $request)
    {
        $variation = Settings::apps("{$request['app']}.type") ?? Isolation::extra($request['type']);

        return 'controller' . Text::append($variation && $variation != 'blade' ? 'api' : '', Settings::seperators('modifier'));
    }
}