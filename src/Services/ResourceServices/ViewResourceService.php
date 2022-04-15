<?php

namespace Bakgul\ResourceCreator\Services\ResourceServices;

use Bakgul\Kernel\Helpers\Path;
use Bakgul\ResourceCreator\Services\RequestServices\ViewRequestService;
use Bakgul\ResourceCreator\Services\ResourceService;

class ViewResourceService extends ResourceService
{
    public function create(array $request): void
    {
        $request = (new ViewRequestService)->handle($request);

        $this->service($request['attr'])->create($request);
    }

    private function service(array $attr)
    {
        return new (implode('\\', [
            __NAMESPACE__,
            "ViewResourceServices",
            ucfirst($attr['type']) . 'ViewResourceService'
        ]));
    }

    protected function class(array $attr, string $namespace, ?string $variation = null): string
    {
        return Path::glue([
            '',
            $namespace,
            'ViewResourceSubServices',
            ucfirst($variation ?: $attr['variation']) . ucfirst($attr['type']) . 'ViewResourceService'
        ], '\\');
    }
}
