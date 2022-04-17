<?php

namespace Bakgul\ResourceCreator\Services\RequestServices\JsRequestServices;

use Bakgul\Kernel\Functions\ConstructPath;
use Bakgul\ResourceCreator\Functions\SetFileName;
use Bakgul\ResourceCreator\Services\RequestServices\JsRequestService;
use Bakgul\ResourceCreator\Vendors\Vanilla;

class VanillaJsRequestService extends JsRequestService
{
    private $vanilla;

    public function handle(array $request): array
    {
        $this->vanilla = new Vanilla;

        $request['attr'] = $this->extendAttr($request);
        $request['map'] = $this->extendMap($request);

        return $request;
    }

    public function extendAttr(array $request): array
    {
        return array_merge($request['attr'], [
            'stub' => $this->vanilla->stub($request['attr']),
            'path' => ConstructPath::_($request),
            'file' => SetFileName::_($request),
        ]);
    }

    private function extendMap(array $request)
    {
        return [
            ...$request['map'],
            'extends' => $this->vanilla->extend($request['attr']),
            'imports' => $this->vanilla->import($request['attr']),
            'export' => $this->vanilla->export($request['attr']['variation'])
        ];
    }
}
