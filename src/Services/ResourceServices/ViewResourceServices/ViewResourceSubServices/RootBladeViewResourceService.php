<?php

namespace Bakgul\ResourceCreator\Services\ResourceServices\ViewResourceServices\ViewResourceSubServices;

use Bakgul\FileContent\Functions\CreateFile;
use Bakgul\ResourceCreator\Services\RequestServices\ViewRequestServices\ViewRequestSubServices\LayoutVueRequestService;
use Bakgul\ResourceCreator\Services\RequestServices\ViewRequestServices\ViewRequestSubServices\RootBladeRequestService;
use Bakgul\ResourceCreator\Services\ResourceServices\ViewResourceServices\BladeViewResourceService;

class RootBladeViewResourceService extends BladeViewResourceService
{
    public function create(array $request): void
    {
        CreateFile::_((new RootBladeRequestService)->handle($request));
    }
}