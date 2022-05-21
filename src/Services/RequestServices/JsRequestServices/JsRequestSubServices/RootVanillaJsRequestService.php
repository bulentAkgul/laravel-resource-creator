<?php

namespace Bakgul\ResourceCreator\Services\RequestServices\JsRequestServices\JsRequestSubServices;

use Bakgul\ResourceCreator\Functions\MakeBasicFixes;
use Bakgul\ResourceCreator\Services\RequestServices\JsRequestServices\VanillaJsRequestService;

class RootVanillaJsRequestService extends VanillaJsRequestService
{
    public function handle(array $request): array
    {
        return MakeBasicFixes::_($request);
    }
}
