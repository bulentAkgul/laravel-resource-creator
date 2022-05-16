<?php

namespace Bakgul\ResourceCreator\Services\ResourceServices\JsResourceServices;

use Bakgul\FileContent\Functions\CreateFile;
use Bakgul\ResourceCreator\Services\RequestServices\JsRequestServices\VanillaJsRequestService;
use Bakgul\ResourceCreator\Services\ResourceServices\JsResourceService;

class VanillaJsResourceService extends JsResourceService
{
    public function create(array $request): void
    {
        CreateFile::_((new VanillaJsRequestService)->handle($request));
    }
}
