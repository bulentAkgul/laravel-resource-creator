<?php

namespace Bakgul\ResourceCreator\Services\ResourceServices\ViewResourceServices\ViewResourceSubServices;

use Bakgul\Kernel\Functions\CreateFile;
use Bakgul\ResourceCreator\Services\RequestServices\ViewRequestServices\ViewRequestSubServices\LivewireBladeRequestService;
use Bakgul\ResourceCreator\Services\ResourceServices\ViewResourceServices\VueViewResourceService;

class LivewireBladeViewResourceService extends VueViewResourceService
{
    public function create(array $request): void
    {
        CreateFile::_((new LivewireBladeRequestService)->handle($request));
    }
}
