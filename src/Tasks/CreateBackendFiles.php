<?php

namespace Bakgul\ResourceCreator\Tasks;

use Bakgul\Kernel\Functions\CreateFileRequest;
use Bakgul\Kernel\Tasks\SimulateArtisanCall;
use Bakgul\Kernel\Helpers\Isolation;
use Bakgul\Kernel\Helpers\Path;
use Bakgul\Kernel\Helpers\Settings;
use Bakgul\Kernel\Helpers\Text;

class CreateBackendFiles
{
    public static function _(array $request, array $queue)
    {
        if (self::isNotCreatable($request, $queue)) return;

        (new SimulateArtisanCall)(CreateFileRequest::_([
            'name' => self::setName($request),
            'type' => self::setType($request),
            'package' => $request['package'],
            'app' => $request['app'],
        ]));
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
        return self::getType($request) != 'blade'
            || (!$request['class'] && Isolation::extra($request['type']) != 'livewire');
    }

    private static function getType($request)
    {
        return Settings::apps("{$request['app']}.type") ?? Isolation::extra($request['type']);
    }

    private static function creatables(array $queue, string $variation): array
    {
        return array_filter($queue, fn ($x) => $x['type'] == 'view' && $x['variation'] == $variation);
    }

    private static function setName(array $request): string
    {
        return self::prependVariationAsSubfolder($request)
            . self::getNameFromOriginalCommand($request);
    }

    private static function prependVariationAsSubfolder(array $request): string
    {
        return Text::prepend(
            self::isLivewire($request) ? Isolation::variation($request['type']) : '',
            Settings::seperators('folder')
        );
    }

    private static function getNameFromOriginalCommand(array $request): string
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
            self::isLivewire($request) => 'livewire',
            $request['type'] == 'view:page' => 'controller',
            default => 'component',
        }) . self::appendVariation($request);
    }

    private static function isLivewire(array $request): bool
    {
        return Isolation::extra($request['type']) == 'livewire';
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
