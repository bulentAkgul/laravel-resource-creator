<?php

namespace Bakgul\ResourceCreator\Services\RequestServices\JsRequestServices;

use Bakgul\ResourceCreator\Functions\RequestFunctions\ConstructPath;
use Bakgul\ResourceCreator\Functions\RequestFunctions\SetFileName;
use Bakgul\ResourceCreator\Services\RequestServices\JsRequestService;
use Bakgul\ResourceCreator\Vendors\Vanilla;

class VanillaJsRequestService extends JsRequestService
{
    private $vanilla;

    public function handle(array $request): array
    {
        $this->vanilla = new Vanilla;

        return [
            'attr' => $this->extendAttr($request),
            'map' => array_merge($request['map'], [
                'extends' => $this->vanilla->extend($request['attr']),
            ]),
        ];
    }

    public function extendAttr(array $request): array
    {
        return array_merge($request['attr'], [
            'stub' => $this->vanilla->stub($request['attr']),
            'path' => ConstructPath::_($request),
            'file' => SetFileName::_($request),
        ]);
    }
}