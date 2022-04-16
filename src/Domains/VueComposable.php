<?php

namespace Bakgul\ResourceCreator\Domains;

use Bakgul\Kernel\Helpers\Arry;
use Bakgul\Kernel\Helpers\Settings;
use Bakgul\ResourceCreator\Vendors\Pinia;
use Bakgul\ResourceCreator\Vendors\Vuex;
use Illuminate\Support\Arr;

class VueComposable
{
    public function __invoke(array $request): array
    {
        return [];
    }
}
