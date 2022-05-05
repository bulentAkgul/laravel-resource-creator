<?php

namespace Bakgul\ResourceCreator\Services\RequestServices;

use Bakgul\Kernel\Helpers\Settings;
use Bakgul\Kernel\Functions\ConstructPath;
use Bakgul\ResourceCreator\Services\RequestService;
use Bakgul\ResourceCreator\Tasks\ExtendResourceMap;

class CssRequestService extends RequestService
{
    public function handle(array $request): array
    {
        $request['attr']['type'] = Settings::main('css');

        $request['map'] = ExtendResourceMap::_($request);

        $request['attr']['path'] = ConstructPath::_($request);

        return $request;
    }
}
