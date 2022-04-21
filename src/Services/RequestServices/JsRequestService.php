<?php

namespace Bakgul\ResourceCreator\Services\RequestServices;

use Bakgul\Kernel\Helpers\Path;
use Bakgul\Kernel\Functions\ConstructPath;
use Bakgul\ResourceCreator\Functions\IsTypescript;
use Bakgul\ResourceCreator\Functions\SetFolder;
use Bakgul\ResourceCreator\Services\RequestService;
use Bakgul\ResourceCreator\Tasks\ExtendResourceMap;

class JsRequestService extends RequestService
{
    public function handle(array $request): array
    {
        $request['attr'] = $this->extendAttr($request['attr']);
        $request['map'] = ExtendResourceMap::_($request);

        return $request;
    }

    public function extendAttr(array $attr): array
    {
        return array_merge($attr, [
            'extension' => $this->setExtension($attr),
            'type' => $this->setType($attr),
            'folder' => SetFolder::_($attr),
            'app_type' => $this->setApp($attr)
        ]);
    }

    private function setExtension(array $attr): string
    {
        return IsTypescript::_($attr) ? 'ts' : 'js';
    }

    private function setType(array $attr)
    {
        return $attr['pipeline']['type'] == 'blade' ? 'vanilla' : $attr['pipeline']['type'];
    }

    private function setApp(array $attr): string
    {
        return $attr['app_type'] ?: $attr['pipeline']['type'];
    }

    protected function updatePath(array $request, string $tail): string
    {
        if ($request['attr']['role'] == 'route') {
            $request['attr']['path'] = Path::head($request['map']['package'], $request['map']['family']) . $tail;
        }
        
        return ConstructPath::_($request);
    }
}
