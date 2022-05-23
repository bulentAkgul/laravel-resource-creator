<?php

namespace Bakgul\ResourceCreator\Services\ResourceServices\ViewResourceServices;

use Bakgul\Kernel\Functions\CallClass;
use Bakgul\FileContent\Functions\CreateFile;
use Bakgul\ResourceCreator\Services\RequestServices\ViewRequestServices\BladeViewRequestService;
use Bakgul\ResourceCreator\Services\ResourceServices\ViewResourceService;
use Bakgul\ResourceCreator\Tasks\CreateComponentClass;
use Bakgul\ResourceCreator\Tasks\CreateController;
use Bakgul\ResourceCreator\Tasks\CreateLivewireClass;

class BladeViewResourceService extends ViewResourceService
{
    public function create(array $request): void
    {
        $request = (new BladeViewRequestService)->handle($request);

        $this->createView($request);

        $this->createBackendFiles($request);
    }

    private function createView($request)
    {
        CallClass::_($request, 'view', __NAMESPACE__, $request['attr']['extra']) ?: CreateFile::_($request);
    }

    private function createBackendFiles($request)
    {
        CreateController::_($request);
        CreateComponentClass::_($request);
        CreateLivewireClass::_($request);
    }
}