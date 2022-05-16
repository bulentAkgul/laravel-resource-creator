<?php

namespace Bakgul\ResourceCreator\Services\ResourceServices\JsResourceServices\JsResourceSubServices;

use Bakgul\FileContent\Functions\CreateFile;
use Bakgul\ResourceCreator\Services\RequestServices\ViewRequestServices\ViewRequestSubServices\RootVueJsRequestService;
use Bakgul\ResourceCreator\Services\ResourceServices\JsResourceServices\VueJsResourceService;

class RootVueJsResourceService extends VueJsResourceService
{
    public function create(array $request): void
    {
        CreateFile::_((new RootVueJsRequestService)->handle($request));
    }
}