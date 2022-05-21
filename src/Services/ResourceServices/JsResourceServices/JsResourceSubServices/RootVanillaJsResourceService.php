<?php

namespace Bakgul\ResourceCreator\Services\ResourceServices\JsResourceServices\JsResourceSubServices;

use Bakgul\FileContent\Functions\CreateFile;
use Bakgul\ResourceCreator\Services\RequestServices\JsRequestServices\JsRequestSubServices\RootVanillaJsRequestService;
use Bakgul\ResourceCreator\Services\ResourceServices\JsResourceServices\VanillaJsResourceService;

class RootVanillaJsResourceService extends VanillaJsResourceService
{
    public function create(array $request): void
    {
        CreateFile::_((new RootVanillaJsRequestService)->handle($request));
    }
}