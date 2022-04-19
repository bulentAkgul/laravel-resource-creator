<?php

namespace Bakgul\ResourceCreator\Services\RequestServices\ViewRequestServices;

use Bakgul\Kernel\Functions\ConstructPath;
use Bakgul\ResourceCreator\Functions\SetFileName;
use Bakgul\ResourceCreator\Services\RequestServices\ViewRequestService;
use Bakgul\ResourceCreator\Domains\VueStore;
use Bakgul\ResourceCreator\Vendors\Vue;

class VueViewRequestService extends ViewRequestService
{
    private $vue;

    public function handle(array $request): array
    {
        $this->vue = new Vue;

        $request['attr'] = $this->extendAttr($request);
        $request['map'] = $this->extendMap($request);

        return $request;
    }

    private function extendAttr(array $request): array
    {
        return array_merge($request['attr'], [
            'file' => SetFileName::_($request),
            'path' => ConstructPath::_($request),
            'stub' => $this->vue->stub($request['attr']['variation']),
        ]);
    }

    protected function extendMap(array $request): array
    {
        return array_merge($request['map'], [
            ...(new VueStore)->code($request),
            ...$this->vue->options($request['attr']),
            'view' => $this->vue->view($request['attr']),
        ]);
    }
}
