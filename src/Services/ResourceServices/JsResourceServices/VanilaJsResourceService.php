<?php

namespace Bakgul\ResourceCreator\Services\ResourceServices\JsResourceServices;

use Bakgul\ResourceCreator\Services\RequestServices\JsRequestServices\VanillaJsRequestService;
use Bakgul\ResourceCreator\Services\ResourceServices\JsResourceService;

class VanilaJsResourceService extends JsResourceService
{
    public function create(array $request): void
    {
        $request = (new VanillaJsRequestService)->handle($request);

        $this->createFile($request);
    }
}
