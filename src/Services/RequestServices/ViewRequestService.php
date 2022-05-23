<?php

namespace Bakgul\ResourceCreator\Services\RequestServices;

use Bakgul\Kernel\Helpers\Settings;
use Bakgul\ResourceCreator\Functions\SetFolder;
use Bakgul\ResourceCreator\Services\RequestService;
use Bakgul\ResourceCreator\Tasks\ExtendResourceMap;

class ViewRequestService extends RequestService
{
    public function handle(array $request): array
    {
        $request['attr'] = $this->extendAttr($request['attr']);

        $request['map'] = ExtendResourceMap::_($request);

        return $request;
    }

    private function extendAttr(array $attr): array
    {
        return array_merge($attr, [
            'category' => $attr['type'],
            'type' => $t = $this->setType($attr),
            'convention' => Settings::resources("{$t}.convention") ?? 'pascal',
            'extension' => Settings::resources("{$t}.extension"),
            'folder' => SetFolder::_($attr),
            'class' => $this->setClass($attr, $t)
        ]);
    }

    private function setType(array $attr): string
    {
        if ($attr['variation'] == 'root') return 'blade';

        return $attr['extra'] && Settings::resources($attr['extra']) ? $attr['extra'] : $attr['app_type'];
    }

    private function setClass(array $attr, $t): bool
    {
        return $t == 'blade' ? ($attr['class']
            ? !Settings::resources('blade.options.class')
            : Settings::resources('blade.options.class')) : $attr['class'];
    }
}
