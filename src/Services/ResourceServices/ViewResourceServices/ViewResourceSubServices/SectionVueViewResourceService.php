<?php

namespace Bakgul\ResourceCreator\Services\ResourceServices\ViewResourceServices\ViewResourceSubServices;

use Bakgul\Kernel\Functions\CreateFile;
use Bakgul\ResourceCreator\Services\RegistrationServices\VueRegistrationServices\VueViewSectionRegistrationService;
use Bakgul\ResourceCreator\Services\ResourceServices\ViewResourceServices\VueViewResourceService;

class SectionVueViewResourceService extends VueViewResourceService
{
    public function create(array $request): void
    {
        CreateFile::_($request);

        (new VueViewSectionRegistrationService)->handle($request);
    }
}