<?php

namespace Bakgul\ResourceCreator\Services\ResourceServices\ViewResourceServices;

use Bakgul\ResourceCreator\Services\RequestServices\ViewRequestServices\BladeViewRequestService;
use Bakgul\ResourceCreator\Services\ResourceServices\ViewResourceService;

class BladeViewResourceService extends ViewResourceService
{
    public function create(array $request): void
    {
        $request = (new BladeViewRequestService)->handle($request);

        $this->callClass($request, $this->class($request['attr'], __NAMESPACE__)) ?: $this->createFile($request);
    }
}