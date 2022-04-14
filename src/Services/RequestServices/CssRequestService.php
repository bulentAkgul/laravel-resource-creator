<?php

namespace Bakgul\ResourceCreator\Services\RequestServices;

use Bakgul\Kernel\Helpers\Settings;
use Bakgul\Kernel\Tasks\ExtendRequestMap;
use Bakgul\ResourceCreator\Services\RequestService;

class CssRequestService extends RequestService
{
    public function handle(array $request): array
    {
        $request['attr']['type'] = Settings::resourceOptions('css');
        
        $request['map'] = $this->extendMap($request);

        $request['attr']['path'] = $this->replace($request['map'], $request['attr']['path'], true);

        return $request;
    }
}