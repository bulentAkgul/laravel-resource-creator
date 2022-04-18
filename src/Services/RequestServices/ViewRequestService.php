<?php

namespace Bakgul\ResourceCreator\Services\RequestServices;

use Bakgul\Kernel\Helpers\Settings;
use Bakgul\ResourceCreator\Functions\SetFolder;
use Bakgul\ResourceCreator\Services\RequestService;

class ViewRequestService extends RequestService
{
    public function handle(array $request): array
    {
        $request['attr'] = $this->extendAttr($request['attr']);
        $request['map'] = $this->extendMap($request);

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
        ]);
    }

    private function setType(array $attr): string
    {
        return $attr['extra'] ?: $attr['app_type'];
    }
}
