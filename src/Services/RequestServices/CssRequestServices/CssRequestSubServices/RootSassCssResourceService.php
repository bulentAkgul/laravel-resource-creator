<?php

namespace Bakgul\ResourceCreator\Services\RequestServices\CssRequestServices\CssRequestSubServices;

use Bakgul\ResourceCreator\Functions\MakeBasicFixes;
use Bakgul\ResourceCreator\Services\RequestServices\CssRequestServices\SassCssRequestService;

class RootSassCssResourceService extends SassCssRequestService
{
    public function handle(array $request): array
    {
        return MakeBasicFixes::_($request);
    }
}