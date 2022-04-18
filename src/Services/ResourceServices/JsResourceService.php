<?php

namespace Bakgul\ResourceCreator\Services\ResourceServices;

use Bakgul\Kernel\Functions\CallClass;
use Bakgul\ResourceCreator\Services\RequestServices\JsRequestService;
use Bakgul\ResourceCreator\Services\ResourceService;

class JsResourceService extends ResourceService
{
    public function create(array $request): void
    {
        CallClass::_((new JsRequestService)->handle($request), 'resource', __NAMESPACE__);
    }
}