<?php

namespace Bakgul\ResourceCreator\Services\ResourceServices;

use Bakgul\Kernel\Helpers\Prevented;
use Bakgul\ResourceCreator\Services\ResourceService;

class CssResourceService extends ResourceService
{
    public function create(array $request): void
    {
        if (Prevented::css()) return;

        //
    }
}