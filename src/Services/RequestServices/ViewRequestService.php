<?php

namespace Bakgul\ResourceCreator\Services\RequestServices;

use Bakgul\Kernel\Helpers\Settings;
use Bakgul\ResourceCreator\Services\RequestService;

class ViewRequestService extends RequestService
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
            'category' => $attr['type'],
            'type' => $t = $attr['extra'] ?: $attr['app_type'],
            'convention' => Settings::resources("{$t}.convention") ?? 'pascal',
            'extension' => Settings::resources("{$t}.extension"),
            'folder' => $this->setFolder($attr),
        ]);
    }
}
