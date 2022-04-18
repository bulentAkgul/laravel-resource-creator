<?php

namespace Bakgul\ResourceCreator\Services\ResourceServices\ViewResourceServices;

use Bakgul\Kernel\Functions\CallClass;
use Bakgul\Kernel\Functions\CreateFile;
use Bakgul\ResourceCreator\Services\RequestServices\ViewRequestServices\BladeViewRequestService;
use Bakgul\ResourceCreator\Services\ResourceServices\ViewResourceService;

class BladeViewResourceService extends ViewResourceService
{
    public function create(array $request): void
    {
        $request = (new BladeViewRequestService)->handle($request);

        CallClass::_($request, 'view', __NAMESPACE__, $request['attr']['extra']) ?: CreateFile::_($request);
    }
}
