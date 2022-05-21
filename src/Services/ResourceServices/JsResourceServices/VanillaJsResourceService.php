<?php

namespace Bakgul\ResourceCreator\Services\ResourceServices\JsResourceServices;

use Bakgul\FileContent\Functions\CreateFile;
use Bakgul\ResourceCreator\Services\RequestServices\JsRequestServices\VanillaJsRequestService;
use Bakgul\ResourceCreator\Services\ResourceServices\JsResourceService;
use Bakgul\ResourceCreator\Services\ResourceServices\JsResourceServices\JsResourceSubServices\RootVanillaJsResourceService;

class VanillaJsResourceService extends JsResourceService
{
    public function create(array $request): void
    {
        $request['attr']['variation'] == 'root'
            ? $this->createRoot($request)
            : $this->createFile($request);
    }

    private function createRoot($request)
    {
        (new RootVanillaJsResourceService)->create(
            (new VanillaJsRequestService)->handle($request)
        );
    }

    private function createFile($request)
    {
        CreateFile::_((new VanillaJsRequestService)->handle($request));
    }
}
