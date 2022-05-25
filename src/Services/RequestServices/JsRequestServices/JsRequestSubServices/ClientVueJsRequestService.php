<?php

namespace Bakgul\ResourceCreator\Services\RequestServices\JsRequestServices\JsRequestSubServices;

use Bakgul\Kernel\Helpers\Text;
use Bakgul\ResourceCreator\Services\RequestServices\ViewRequestService;

class ClientVueJsRequestService extends ViewRequestService
{
    public static function main(array $request): array
    {
        $request['attr']['job'] = 'package';
        $request['attr']['file'] = "{$request['attr']['name']}.{$request['attr']['extension']}";
        $request['attr']['stub'] = 'js.vue.export.stub';
        $request['attr']['path'] = self::setPath($request['attr']);

        $request['map']['brackets'] = $request['attr']['role'] == 'route' ? '[]' : '{}';

        return $request;
    }

    private static function setPath(array $attr): string
    {
        return Text::dropTail($attr['path'], length: $attr['role'] == 'route' ? 1 : 2);
    }
}
