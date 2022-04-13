<?php

namespace Bakgul\ResourceCreator\Services\RequestServices;

use Bakgul\Kernel\Helpers\Path;
use Bakgul\ResourceCreator\Services\RequestService;

class JsRequestService extends RequestService
{
    public function handle(array $request): array
    {
        $request['attr'] = $this->modifyAttr($request['attr']);
        $request['map'] = $this->extendMap($request);

        return $request;
    }

    public function modifyAttr(array $attr): array
    {
        return array_merge($attr, [
            'folder' => $this->setFolder($attr),
            'app_type' => $attr['app_type'] ?: $attr['pipeline']['type'],
        ]);
    }

    protected function updatePath(array $request, string $tail): string
    {
        $request['attr']['path'] = Path::head($request['map']['package'], $request['map']['family']) . $tail;

        return $this->makeReplacements($request, 'path');
    }
}