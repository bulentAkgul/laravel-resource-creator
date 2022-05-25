<?php

namespace Bakgul\ResourceCreator\Services\ResourceServices\JsResourceServices\JsResourceSubServices;

use Bakgul\FileContent\Functions\CreateFile;
use Bakgul\ResourceCreator\Services\RegistrationServices\VueRegistrationServices\VueRoutePackageRegistrationService;
use Bakgul\ResourceCreator\Services\RegistrationServices\VueRegistrationServices\VueStorePackageRegistrationService;
use Bakgul\ResourceCreator\Services\RequestServices\JsRequestServices\JsRequestSubServices\ClientVueJsRequestService;
use Bakgul\ResourceCreator\Services\ResourceServices\JsResourceServices\VueJsResourceService;

class ClientVueJsResourceService extends VueJsResourceService
{
    public function create(array $request): void
    {
        $request = ClientVueJsRequestService::main($request);

        CreateFile::_($request);

        match ($request['attr']['role']) {
            'route' => (new VueRoutePackageRegistrationService)->handle($request),
            'store' => (new VueStorePackageRegistrationService)->handle($request),
            default => null
        };
    }
}
