<?php

namespace Bakgul\ResourceCreator\Services\ResourceServices;

use Bakgul\Kernel\Functions\CallClass;
use Bakgul\Kernel\Helpers\Prevented;
use Bakgul\ResourceCreator\Services\RequestServices\CssRequestService;
use Bakgul\ResourceCreator\Services\ResourceService;

class CssResourceService extends ResourceService
{
    public function create(array $request): void
    {
        if (Prevented::css()) return;

        CallClass::_((new CssRequestService)->handle($request), 'resource', __NAMESPACE__);
    }
}