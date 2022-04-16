<?php

namespace Bakgul\ResourceCreator\Vendors;

class Vuex
{
    public function vendor(): string
    {
        return 'vuex';
    }

    public function mapFunctions(): array
    {
        return ['computeds' => ['State', 'Getters'], 'methods' => ['Actions']];
    }

    public function mapFunction(): string
    {
        return '{}';
    }

    public function import(): string
    {
        return '';
    }

    public function stub(string $variation): string
    {
        return 'js.vue.' . ($variation == 'section' ? 'section' : 'vuex') . '.stub';
    }

    public function file(array $map): string
    {
        return "{$map['name']}.js";
    }
}
