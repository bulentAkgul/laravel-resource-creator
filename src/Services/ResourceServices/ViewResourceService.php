<?php

namespace Bakgul\ResourceCreator\Services\ResourceServices;

use Bakgul\Kernel\Functions\CallClass;
use Bakgul\ResourceCreator\Services\RequestServices\ViewRequestService;
use Bakgul\ResourceCreator\Services\ResourceService;

class ViewResourceService extends ResourceService
{
    public function create(array $request): void
    {
        CallClass::_((new ViewRequestService)->handle($request), 'resource', __NAMESPACE__);
    }
}
