<?php

namespace Bakgul\ResourceCreator\Services\ResourceServices\ViewResourceServices\ViewResourceSubServices;

use Bakgul\Kernel\Functions\CreateFile;
use Bakgul\ResourceCreator\Services\RegistrationServices\VueRegistrationServices\VueViewPageRegistrationService;
use Bakgul\ResourceCreator\Services\ResourceServices\ViewResourceServices\VueViewResourceService;

class PageVueViewResourceService extends VueViewResourceService
{
    public function create(array $request): void
    {
        CreateFile::_($request);

        (new VueViewPageRegistrationService)->handle($request);
    }
}