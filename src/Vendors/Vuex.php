<?php

namespace Bakgul\ResourceCreator\Vendors;

use Bakgul\Kernel\Helpers\Settings;
use Bakgul\Kernel\Helpers\Text;

class Vuex
{
    public function vendor(): string
    {
        return 'vuex';
    }

    public function stub(string $variation): string
    {
        return 'js.vue.' . ($variation == 'section' ? 'section' : 'vuex') . '.stub';
    }

    public function mapFunctions(?string $key = '')
    {
        return Settings::resources('vuex.maps' . Text::append($key, '.'));
    }

    public function mapFunction(): string
    {
        return '{}';
    }

    public function import(): string
    {
        return '';
    }

    public function file(array $map): string
    {
        return $map['name'];
    }
}
