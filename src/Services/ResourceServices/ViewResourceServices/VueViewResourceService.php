<?php

namespace Bakgul\ResourceCreator\Services\ResourceServices\ViewResourceServices;

use Bakgul\Kernel\Functions\CallClass;
use Bakgul\Kernel\Functions\CreateFile;
use Bakgul\ResourceCreator\Services\RequestServices\ViewRequestServices\VueViewRequestService;
use Bakgul\ResourceCreator\Services\ResourceServices\ViewResourceService;
use Bakgul\ResourceCreator\Vendors\Vue;

class VueViewResourceService extends ViewResourceService
{
    public function create(array $request): void
    {
        $request = (new VueViewRequestService)->handle($request);

        CallClass::_($request, 'view', __NAMESPACE__) ?: CreateFile::_($request);

        (new Vue)->removeOptionsAPI($request['attr']);
    }
}
