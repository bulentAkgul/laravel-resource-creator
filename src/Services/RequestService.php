<?php

namespace Bakgul\ResourceCreator\Services;

use Bakgul\Kernel\Helpers\Arry;
use Bakgul\Kernel\Helpers\Settings;
use Bakgul\Kernel\Helpers\Text;
use Bakgul\Kernel\Tasks\ConvertCase;
use Bakgul\Kernel\Tasks\ExtendRequestMap;
use Bakgul\Kernel\Tasks\SetRequestAttr;
use Bakgul\ResourceCreator\ResourceCreator;
use Bakgul\ResourceCreator\Tasks\SetCase;

class RequestService extends ResourceCreator
{
    public function handle(array $request): array
    {
        return [
            'attr' => $a = $this->generateAttr($request),
            'map' => $this->generateMap($a)
        ];
    }

    private function generateAttr(array $request)
    {
        return [
            ...SetRequestAttr::_($request),
            'sharing' => $this->isSharable($request['variation']),
            'job' => 'resource'
        ];
    }
    
    public function isSharable($variation): bool
    {
        return in_array($variation, Settings::resourceOptions('levels.low'))
            && Settings::resourceOptions('share_low_levels_betwen_apps');
    }

    private function generateMap(array $attr): array
    {
        return [
            ...$this->setApps($attr),
            'package' => $attr['package'],
            'family' => $attr['family'],
        ];
    }

    private function setApps($attr)
    {
        return [
            'apps' => $attr['sharing'] ? '' : Settings::folders('apps'),
            'app' => $attr['sharing'] ? Settings::folders('shared') : $attr['app_folder'],
        ];
    }

    protected function extendMap(array $request): array
    {
        $map = ExtendRequestMap::_($request);

        return [
            ...$map,
            'name' => $n = $this->setName($request['attr'], $map),
            'name_pascal' => ConvertCase::pascal($n),
            'container' => ConvertCase::kebab($map['container']),
            'folder' => $this->setFolder($request['attr']),
            'role' => '',
        ];
    }

    protected function setName(array $attr, array $map): string
    {
        return ConvertCase::{$attr['convention']}(implode('-', array_filter([
            $this->setPrefix($attr), $map['name'], $attr['task']
        ])));
    }

    public function setParent(array $attr): string
    {
        return ConvertCase::{$attr['convention']}($attr['parent']['name']);
    }

    private function setPrefix(array $attr): ?string
    {
        return Settings::resourceOptions('use_prefix') ? Settings::prefixes($attr['variation']) : '';
    }

    protected static function setFolder(array $attr): string
    {
        if (Arry::has('folder', $attr)) return ConvertCase::{$attr['convention']}($attr['folder']);

        return in_array($attr['variation'], Settings::resourceOptions('section_parents'))
            ? $attr['name']
            : ($attr['variation'] == 'section' ? ($attr['parent']['name'] ?: $attr['name']) : '');
    }

    protected function setFile(array $request): string
    {
        return ConvertCase::{SetCase::_($request['attr'])}($request['map']['name'])
             . ".{$request['attr']['extension']}";
    }
    protected function setPath(array $request): string
    {
        return $this->replace($request['map'], $request['attr']['path'], true);
    }

    protected function getFolder($key, $convention): string
    {
        return ConvertCase::_(Settings::folders($key), $convention);
    }

    protected function makeReplacements(array $request, string $key)
    {
        return $this->replace($request['map'], $request['attr'][$key], str_contains($key, 'path'));
    }

    protected function replace(array $map, string $value, bool $append = false)
    {
        return Text::replaceByMap($map, $value, $append);
    }
}
