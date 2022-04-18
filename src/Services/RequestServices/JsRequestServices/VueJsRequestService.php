<?php

namespace Bakgul\ResourceCreator\Services\RequestServices\JsRequestServices;

use Bakgul\ResourceCreator\Domains\VueComposable;
use Bakgul\ResourceCreator\Domains\VueRoute;
use Bakgul\ResourceCreator\Domains\VueStore;
use Bakgul\ResourceCreator\Functions\ConvertValue;
use Bakgul\ResourceCreator\Services\RequestServices\JsRequestService;

class VueJsRequestService extends JsRequestService
{
    private $service;

    public function __construct(private string $role) {}

    public function handle(array $request): array
    {
        $this->setService($request);

        $request['attr'] = $this->extendAttr($request);
        $request['map'] = $this->extendMap($request);

        return $this->modify($request);
    }

    private function setService(array $request): void
    {
        $this->service = match ($this->role) {
            'route' => new VueRoute($request),
            'store' => new VueStore,
            'mixin' => new VueComposable,
            default => null
        };
    }

    public function extendAttr(array $request): array
    {
        return array_merge($request['attr'], [
            'role' => $this->role,
            'stub' => $this->service->stub($request),
            'file' => $this->service->file($request)
        ]);
    }

    public function extendMap(array $request): array
    {
        return array_merge($request['map'], [
            'id' => ConvertValue::_($request['map']['name'], 'camel'),
            'role' => ConvertValue::_($request['attr'], 'role', false),
        ]);
    }

    private function setRoute(array $request)
    {
        return $this->role == 'route' ? $this->service->route($request['attr']) : '';
    }

    public function modify(array $request): array
    {
        $request['attr']['path'] = $this->setPath($request);

        $request['map']['route'] = $this->setRoute($request);
        $request['map']['imports'] = $this->setImports($request);
        $request['map']['component'] = $this->setComponent($request);
        
        return $request;
    }

    private function setPath(array $request): string
    {
        return $this->updatePath($request, $this->service->schema($request['attr']));
    }

    private function setImports(array $request): string
    {
        return $this->role == 'route' ? $this->service->imports($request) : '';
    }

    private function setComponent(array $request): string
    {
        return $this->role == 'route' ? $this->service->component($request) : '';
    }
}
