<?php

namespace Bakgul\ResourceCreator\Domains;

use Bakgul\Kernel\Helpers\Arry;
use Bakgul\Kernel\Helpers\Settings;
use Bakgul\ResourceCreator\Vendors\Pinia;
use Bakgul\ResourceCreator\Vendors\Vuex;
use Illuminate\Support\Arr;

class VueStore
{
    private $store;

    public function __construct() {
        $this->store = match (Settings::resources("vue.options.store")) {
            'pinia' => new Pinia,
            'vuex' => new Vuex,
            default => null
        };
    }

    public function stub(array $request)
    {
        return $this->store->stub($request['attr']['variation']);
    }

    public function file(array $request): string
    {
        return "{$this->store->file($request['map'])}.js";
    }

    public function code(array $request): array
    {
        if ($this->isNotStorable($request['attr']['variation'])) return $this->empty();

        return array_combine(array_keys($this->empty()), $this->makeValues($request));
    }

    private function empty(): array
    {
        return ['computeds' => '', 'methods' => '', 'imports' => ''];
    }

    private function makeValues(array $request): array
    {
        return [
            $this->setFunction($request['map'], 'computeds'),
            $this->setFunction($request['map'], 'methods'),
            $this->setImports($request),
        ];
    }

    private function setFunction($map, $key)
    {
        $func = implode('', array_map(
            fn ($x) => PHP_EOL . "\t\t...map{$x}({$this->store->mapFunction($map)}),",
            Arr::get($this->store->mapFunctions(), $key) ?? []
        ));

        return $func ? $func . PHP_EOL . "\t" : '';
    }

    private function setImports(array $request): string
    {
        $func = Arry::sort(Arr::flatten($this->store->mapFunctions()) ?? []);

        return empty($func) ? '' : implode(PHP_EOL, array_filter([
            $this->setMapFunctions($func), $this->setFileImports($request)
        ]));
    }

    private function setMapFunctions($func)
    {
        return 'import { '
            . implode(', ', array_map(fn ($x) => "map{$x}", $func))
            . ' } from "'
            . $this->store->vendor()
            . '";';
    }

    private function setFileImports(array $request): string
    {
        return match($this->store->vendor()) {
            'pinia' => $this->store->import($request),
            default => ''
        };
    }

    private function isNotStorable(string $variation): bool
    {
        return in_array($variation, Settings::resourceOptions('levels.low')) || !$this->store;
    }

    public function schema(array $attr): string
    {
        return $attr['path_schema'];
    }
}
