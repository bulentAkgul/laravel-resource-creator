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
        return array_merge($a = SetRequestAttr::_($request), [
            'sharing' => $this->isSharable($request['variation']),
            'job' => 'resource',
            'parent' => $this->updateParent($a),
            'path' => $this->updatePath($a, 'path'),
            'path_schema' => $this->updatePath($a, 'path_schema'),
            'prefix' => $this->setPrefix($request['variation'])
        ]);
    }
    
    public function isSharable($variation): bool
    {
        return in_array($variation, Settings::resourceOptions('levels.low'))
            && Settings::resourceOptions('share_low_levels_betwen_apps');
    }

    private function updateParent(array $attr): array
    {
        return Arry::has('wrapper', $attr)
            ? [...$attr['parent'], 'name' => $attr['wrapper']]
            : $attr['parent'];
    }

    private function updatePath($attr, $key)
    {
        return Arry::has('wrapper', $attr)
            ? str_replace('{{ folder }}', '{{ wrapper }}', $attr[$key])
            : $attr[$key];
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
            'wrapper' => $this->setWrapper($request['attr']),
            'role' => '',
        ];
    }

    protected function setName(array $attr, array $map): string
    {
        return ConvertCase::{$attr['convention']}(
            $this->replace($map, $attr['name_schema'], true, '-')
        );
    }

    public function setParent(array $attr): string
    {
        return ConvertCase::{$attr['convention']}($attr['parent']['name']);
    }

    private function setPrefix(string $variation): string
    {
        return Settings::resourceOptions('use_prefix') ? Settings::prefixes($variation) : '';
    }

    protected static function setFolder(array $attr): string
    {
        if (Arry::has('folder', $attr)) return ConvertCase::{$attr['convention']}($attr['folder']);

        return in_array($attr['variation'], Settings::resourceOptions('section_parents'))
            ? $attr['name']
            : ($attr['variation'] == 'section' ? ($attr['parent']['name'] ?: $attr['name']) : '');
    }

    private function setWrapper(array $attr): string
    {
        return ConvertCase::_(Arry::get($attr, 'wrapper') ?? '', $attr['convention']);
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

    protected function replace(array $map, string $value, bool $append = false, ?string $glue = null)
    {
        return Text::replaceByMap($map, $value, $append, $glue);
    }
}
