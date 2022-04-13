<?php

namespace Bakgul\ResourceCreator\Services\ResourceServices\JsResourceServices;

use Bakgul\ResourceCreator\Services\RequestServices\JsRequestServices\BladeJsRequestService;
use Bakgul\ResourceCreator\Services\ResourceServices\JsResourceService;

class BladeJsResourceService extends JsResourceService
{
    public function create(array $request): void
    {
        $request = (new BladeJsRequestService)->handle($request);
        ray($request);
        $this->createFile($request);
    }
}
