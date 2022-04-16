<?php

namespace Bakgul\ResourceCreator\Services\RequestServices\JsRequestServices;

use Bakgul\ResourceCreator\Domains\VueComposable;
use Bakgul\ResourceCreator\Domains\VueRoute;
use Bakgul\ResourceCreator\Domains\VueStore;
use Bakgul\ResourceCreator\Functions\RequestFunctions\ConvertValue;
use Bakgul\ResourceCreator\Services\RequestServices\JsRequestService;

class VueJsRequestService extends JsRequestService
{
    public function __construct(private string $role)
    {
        $this->service = match ($role) {
            'route' => new VueRoute,
            'store' => new VueStore,
            'mixin' => new VueComposable,
            default => null
        };
    }

    public function handle(array $request): array
    {
        $request['attr'] = $this->extendAttr($request);
        $request['map'] = $this->extendMap($request);

        return $this->modify($request);
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
            'route' => $this->setRoute($request),
            'imports' => '',
        ]);
    }

    private function setRoute(array $request)
    {
        return $this->role == 'route' ? $this->service->route($request) : '';
    }

    public function modify(array $request): array
    {
        $request['attr']['path'] = $this->updatePath($request, $this->service->schema($request['attr']));

        return $request;
    }
}
