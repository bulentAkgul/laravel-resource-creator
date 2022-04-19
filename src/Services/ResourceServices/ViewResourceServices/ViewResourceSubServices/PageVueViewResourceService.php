<?php

namespace Bakgul\ResourceCreator\Services\ResourceServices\ViewResourceServices\ViewResourceSubServices;

use Bakgul\Kernel\Functions\CreateFile;
use Bakgul\ResourceCreator\Services\RegistrationServices\VueRegistrationServices\VueViewSectionRegistrationService;
use Bakgul\ResourceCreator\Services\ResourceServices\ViewResourceServices\VueViewResourceService;
use Bakgul\ResourceCreator\Vendors\Inertia;

class PageVueViewResourceService extends VueViewResourceService
{
    public function create(array $request): void
    {
        $inertia = new Inertia;

        $inertia->makeLayout($request);

        $request = $inertia->vuePageAdaptor($request);

        CreateFile::_($request);
    }
}
