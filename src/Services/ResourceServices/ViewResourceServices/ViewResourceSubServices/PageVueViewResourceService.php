<?php

namespace Bakgul\ResourceCreator\Services\ResourceServices\ViewResourceServices\ViewResourceSubServices;

use Bakgul\Kernel\Helpers\Settings;
use Bakgul\ResourceCreator\Services\RegistrationServices\VueRegistrationServices\VueViewPageRegistrationService;
use Bakgul\ResourceCreator\Services\ResourceServices\ViewResourceServices\VueViewResourceService;

class PageVueViewResourceService extends VueViewResourceService
{
    public function create(array $request): void
    {
        $this->createFile($request);

        if (!Settings::resources('vue.options.route')) return;
        
        (new VueViewPageRegistrationService)->handle($request);
    }
}