<?php

namespace Bakgul\ResourceCreator\Services\ResourceServices\JsResourceServices\JsResourceSubServices;

use Bakgul\FileContent\Functions\CreateFile;
use Bakgul\Kernel\Helpers\Settings;
use Bakgul\ResourceCreator\Services\RequestServices\JsRequestServices\JsRequestSubServices\RootVueJsRequestService;
use Bakgul\ResourceCreator\Services\ResourceServices\JsResourceServices\VueJsResourceService;

class RootVueJsResourceService extends VueJsResourceService
{
    public function create(array $request): void
    {
        CreateFile::_(RootVueJsRequestService::main($request));
        
        if (Settings::resources('vue.options.store')) {
            CreateFile::_(RootVueJsRequestService::{Settings::resources('vue.options.store')}($request));
        }
        
        if (!in_array($request['attr']['router'], Settings::prohibitives('route'))) {
            CreateFile::_(RootVueJsRequestService::router($request));
        }
    }
}