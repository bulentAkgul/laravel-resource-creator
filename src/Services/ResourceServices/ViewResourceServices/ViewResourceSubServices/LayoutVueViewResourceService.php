<?php

namespace Bakgul\ResourceCreator\Services\ResourceServices\ViewResourceServices\ViewResourceSubServices;

use Bakgul\Kernel\Functions\CreateFile;
use Bakgul\ResourceCreator\Services\RequestServices\ViewRequestServices\ViewRequestSubServices\LayoutVueRequestService;
use Bakgul\ResourceCreator\Services\ResourceServices\ViewResourceServices\VueViewResourceService;

class LayoutVueViewResourceService extends VueViewResourceService
{
    public function create(array $request): void
    {
        CreateFile::_((new LayoutVueRequestService)->handle($request));
    }
}