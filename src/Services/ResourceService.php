<?php

namespace Bakgul\ResourceCreator\Services;

use Bakgul\Kernel\Services\NotExpectedTypeService;
use Bakgul\ResourceCreator\ResourceCreator;
use Bakgul\ResourceCreator\Services\ResourceServices\CssResourceService;
use Bakgul\ResourceCreator\Services\ResourceServices\JsResourceService;
use Bakgul\ResourceCreator\Services\ResourceServices\ViewResourceService;

class ResourceService extends ResourceCreator
{
    public function create(array $request): void
    {
        $request = (new RequestService)->handle($request);

        $this->service($request['attr']['type'])->create($request);
    }

    private function service(string $type): ?object
    {
        return match ($type) {
            'view' => new ViewResourceService,
            'js' => new JsResourceService,
            'css' => new CssResourceService,
            default => new NotExpectedTypeService
        };
    }
}
