<?php

namespace Bakgul\ResourceCreator\Tasks;

use Bakgul\Kernel\Helpers\Arry;
use Bakgul\Kernel\Helpers\Isolation;
use Bakgul\Kernel\Helpers\Path;
use Bakgul\Kernel\Helpers\Settings;
use Bakgul\Kernel\Helpers\Text;
use Illuminate\Support\Facades\Artisan;

class CreateBackendFiles
{
    public static function _(array $request, array $queue)
    {
        if (self::isNotCreatable($request, $queue)) return;

        Artisan::call(self::createCommand($request));
    }

    public static function isNotCreatable(array $request, array $queue): bool
    {
        return self::isNotView($request['type'])
            || self::hasNoFileCreator()
            || (self::hasNoController($queue) && self::hasNoClassPair($request));
    }

    private static function isNotView($type)
    {
        return Isolation::type($type) != 'view';
    }

    private static function hasNoFileCreator()
    {
        return !file_exists(Path::realBase(Path::glue(['vendor', 'bakgul', 'laravel-file-creator'])));
    }

    private static function hasNoController($queue)
    {
        return !Settings::resourceOptions('each_page_has_controller')
            || empty(self::creatables($queue, 'page'));
    }

    private static function hasNoClassPair(array $request): bool
    {
        return self::getType($request) != 'blade' || (!$request['class'] && $request['extra'] != 'livewire'
        );
    }

    private static function getType($request)
    {
        return Settings::apps("{$request['app']}.type") ?? Isolation::extra($request['type']);
    }

    private static function creatables(array $queue, string $variation): array
    {
        return array_filter($queue, fn ($x) => $x['type'] == 'view' && $x['variation'] == $variation);
    }

    private static function createCommand(array $request): string
    {
        return implode(' ', array_filter([
            'create:file',
            self::setName($request),
            self::setType($request),
            $request['package'],
            $request['app'],
        ]));
    }

    private static function setName(array $request)
    {
        return Text::changeTail(
            $request['name'],
            self::setPrefixedName($request),
            Settings::seperators('folder')
        );
    }

    private static function setPrefixedName(array $request): string
    {
        return implode('-', array_filter([self::setPrefix($request['type']), Isolation::name($request['name'])]));
    }

    private static function setPrefix(string $type): string
    {
        return Settings::resourceOptions('use_prefix') ? Settings::prefixes(Isolation::variation($type)) : '';
    }

    private static function setType(array $request)
    {
        return (match (true) {
            Arry::get($request, 'extra') == 'livewire' => 'livewire',
            $request['type'] == 'page' => 'controller',
            default => 'component',
        }) . self::appendVariation($request);
    }

    private static function appendVariation($request)
    {
        return Text::append(self::isApi($request) ? 'api' : '', Settings::seperators('modifier'));
    }

    private static function isApi($request)
    {
        return Isolation::variation($request['type']) == 'page'
            && self::getType($request) != 'blade'
            && Settings::apps("{$request['app']}.router") != 'inertia';
    }
}
