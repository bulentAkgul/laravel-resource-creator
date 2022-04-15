<?php

namespace Bakgul\ResourceCreator\Services\ResourceServices\ViewResourceServices\ViewResourceSubServices;

use Bakgul\ResourceCreator\Services\RequestServices\ViewRequestServices\ViewRequestSubServices\LivewireBladeRequestService;
use Bakgul\ResourceCreator\Services\ResourceServices\ViewResourceServices\VueViewResourceService;

class LivewireBladeViewResourceService extends VueViewResourceService
{
    public function create(array $request): void
    {
        $this->createFile((new LivewireBladeRequestService)->handle($request));
    }
}