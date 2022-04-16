<?php

namespace Bakgul\ResourceCreator\Services\RequestServices\ViewRequestServices;

use Bakgul\Kernel\Tasks\ConvertCase;
use Bakgul\ResourceCreator\Functions\RequestFunctions\ConstructPath;
use Bakgul\ResourceCreator\Functions\RequestFunctions\SetFileName;
use Bakgul\ResourceCreator\Services\RequestServices\ViewRequestService;
use Bakgul\ResourceCreator\Vendors\Blade;

class BladeViewRequestService extends ViewRequestService
{
    private $blade;

    public function handle(array $request): array
    {
        $this->blade = new Blade;

        $request['attr'] = $this->extendAttr($request);
        $request['map'] = $this->extendMap($request);

        return $request;
    }

    private function extendAttr(array $request): array
    {
        return array_merge($request['attr'], [
            'file' => SetFileName::_($request),
            'stub' => $this->blade->stub($request),
            'path' => ConstructPath::_($request),
        ]);
    }

    protected function extendMap(array $request): array
    {
        return array_merge($request['map'], [
            'extend' => '',
            'name_kebab' => ConvertCase::kebab($request['map']['name']),
            'extend_page' => $this->blade->extend($request['attr']),
            'package' => $this->blade->package($request['map']['package']),
        ]);
    }
}
