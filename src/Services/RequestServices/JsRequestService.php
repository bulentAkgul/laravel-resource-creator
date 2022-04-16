<?php

namespace Bakgul\ResourceCreator\Services\RequestServices;

use Bakgul\Kernel\Helpers\Path;
use Bakgul\ResourceCreator\Functions\RequestFunctions\ConstructPath;
use Bakgul\ResourceCreator\Functions\RequestFunctions\SetFolder;
use Bakgul\ResourceCreator\Services\RequestService;
use Bakgul\ResourceCreator\Tasks\RequestTasks\ExtendMap;

class JsRequestService extends RequestService
{
    public function handle(array $request): array
    {
        $request['attr'] = $this->extendAttr($request['attr']);
        $request['map'] = ExtendMap::_($request);

        return $request;
    }

    public function extendAttr(array $attr): array
    {
        return array_merge($attr, [
            'type' => $this->setType($attr),
            'folder' => SetFolder::_($attr),
            'app_type' => $this->setApp($attr)
        ]);
    }

    private function setType(array $attr)
    {
        return $attr['type'] == 'blade' ? 'vanilla' : $attr['type'];
    }

    private function setApp(array $attr): string
    {
        return $attr['app_type'] ?: $attr['pipeline']['type'];
    }

    protected function updatePath(array $request, string $tail): string
    {
        $request['attr']['path'] = Path::head($request['map']['package'], $request['map']['family']) . $tail;

        return ConstructPath::_($request);
    }
}