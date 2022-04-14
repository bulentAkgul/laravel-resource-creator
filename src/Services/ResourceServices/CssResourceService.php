<?php

namespace Bakgul\ResourceCreator\Services\ResourceServices;

use Bakgul\Kernel\Helpers\Prevented;
use Bakgul\ResourceCreator\Services\RequestServices\CssRequestService;
use Bakgul\ResourceCreator\Services\ResourceService;

class CssResourceService extends ResourceService
{
    public function create(array $request): void
    {
        if (Prevented::css()) return;

        $request = (new CssRequestService)->handle($request);

        $this->service($request['attr'])?->create($request);
    }

    private function service(array $attr)
    {
        return new (implode('\\', [
            __NAMESPACE__,
            "CssResourceServices",
            ucfirst($attr['type']) . 'CssResourceService'
        ]));
    }
}