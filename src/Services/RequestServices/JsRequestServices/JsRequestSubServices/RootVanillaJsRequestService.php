<?php

namespace Bakgul\ResourceCreator\Services\RequestServices\JsRequestServices\JsRequestSubServices;

use Bakgul\Kernel\Helpers\Text;
use Bakgul\Kernel\Tasks\ConvertCase;
use Bakgul\ResourceCreator\Services\RequestServices\JsRequestServices\VanillaJsRequestService;

class RootVanillaJsRequestService extends VanillaJsRequestService
{
    public function handle(array $request): array
    {
        $request['attr']['path'] = Text::dropTail($request['attr']['path'], length: 2);
        $request['attr']['file'] = "{$request['attr']['app_folder']}.{$request['attr']['extension']}";

        return $request;
    }
}
