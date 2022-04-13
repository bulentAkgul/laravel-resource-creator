<?php

namespace Bakgul\ResourceCreator\Services\RequestServices\ViewRequestServices;

use Bakgul\Kernel\Helpers\Arry;
use Bakgul\Kernel\Helpers\Settings;
use Bakgul\Kernel\Helpers\Text;
use Bakgul\ResourceCreator\Helpers\Options;
use Bakgul\ResourceCreator\Helpers\Pinia;
use Bakgul\ResourceCreator\Services\RequestServices\ViewRequestService;
use Illuminate\Support\Arr;

class VueViewRequestService extends ViewRequestService
{
    private $store;
    const FUNC = [
        'vuex' => ['computeds' => ['State', 'Getters'], 'methods' => ['Actions']],
        'pinia' => ['computeds' => ['State'], 'methods' => ['Actions']],
    ];

    public function handle(array $request): array
    {
        $request['attr'] = $this->extendAttr($request);
        $request['map'] = $this->extendMap($request);

        return $request;
    }

    private function extendAttr(array $request): array
    {
        return array_merge($request['attr'], [
            'file' => $this->setFile($request),
            'stub' => $this->setStub($request),
            'path' => $this->setPath($request),
        ]);
    }

    private function setStub(array $request): string
    {
        return "vue.{$request['attr']['variation']}.stub";
    }

    protected function extendMap(array $request): array
    {
        return array_merge($request['map'], [
            ...$this->setStore($request),
            ...$this->setOptions($request['attr']['pipeline']['options']),
            'view' => $this->setView($request['attr']['variation']),
        ]);
    }

    private function setView(string $variation)
    {
        return $variation == 'page' ? Text::inject("  <router-view />", PHP_EOL) : '';
    }

    private function setOptions(array $options): array
    {
        return [
            'setup' => Arry::get($options, 'compositionAPI') ? ' setup' : '',
            'lang' => Arry::get($options, 'ts') && Arry::get($options, 'compositionAPI') ? ' lang="ts"' : '',
        ];
    }

    private function setStore(array $request): array
    {
        if ($this->isNotStorable($request['attr'])) return ['methods' => '', 'computeds' => '', 'imports' => ''];

        $this->store = $request['attr']['pipeline']['options']['store'] ?: 'none';

        return [
            'computeds' => $this->setFunction($request['map'], 'computeds'),
            'methods' => $this->setFunction($request['map'], 'methods'),
            'imports' => $this->setImports($request),
        ];
    }

    private function setFunction($map, $key)
    {
        $func = implode('', array_map(
            fn ($x) => PHP_EOL . "\t\t...map{$x}({$this->mapFunction($map)}),",
            Arr::get(self::FUNC, "{$this->store}.{$key}") ?? []
        ));

        return $func ? $func . PHP_EOL . "\t" : '';
    }

    private function mapFunction(array $map)
    {
        return $this->store == 'pinia' ? Pinia::mapFunction($map) : '{}';
    }

    private function setImports(array $request): string
    {
        $func = Arry::sort(Arr::flatten(Arry::get(self::FUNC, $this->store) ?? []));

        return empty($func) ? '' : PHP_EOL . implode(PHP_EOL, array_filter([
            $this->setMapFunctions($func), Pinia::import($request)
        ]));
    }

    private function setMapFunctions($func)
    {
        return 'import { '
            . implode(', ', array_map(fn ($x) => "map{$x}", $func))
            . ' } from "'
            . $this->store
            . '";';
    }

    private function isNotStorable($attr)
    {
        return in_array($attr['variation'], Settings::resourceOptions('levels.low'))
            || !(Settings::resources("{$attr['type']}.options.store") ?: Arr::get($attr, 'pipeline.options.store'));
    }
}
