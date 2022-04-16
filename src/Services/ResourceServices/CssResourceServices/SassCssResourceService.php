<?php

namespace Bakgul\ResourceCreator\Services\ResourceServices\CssResourceServices;

use Bakgul\Kernel\Functions\CreateFile;
use Bakgul\ResourceCreator\Services\RegistrationServices\CssRegistrationServices\SassCssRegistrationService;
use Bakgul\ResourceCreator\Services\RequestServices\CssRequestServices\SassCssRequestService;
use Bakgul\ResourceCreator\Services\ResourceServices\CssResourceService;

class SassCssResourceService extends CssResourceService
{
    public function create(array $request): void
    {
        $request = (new SassCssRequestService)->handle($request);

        CreateFile::_($request);

        (new SassCssRegistrationService)->handle($request);
    }
}