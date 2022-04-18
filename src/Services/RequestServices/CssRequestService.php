<?php

namespace Bakgul\ResourceCreator\Services\RequestServices;

use Bakgul\Kernel\Helpers\Settings;
use Bakgul\Kernel\Functions\ConstructPath;
use Bakgul\ResourceCreator\Services\RequestService;
use Bakgul\ResourceCreator\Tasks\ExtendMap;

class CssRequestService extends RequestService
{
    public function handle(array $request): array
    {
        $request['attr']['type'] = Settings::resourceOptions('css');

        $request['map'] = ExtendMap::_($request);

        $request['attr']['path'] = ConstructPath::_($request);

        return $request;
    }
}
