<?php

namespace Bakgul\ResourceCreator\Tasks;

use Bakgul\Kernel\Functions\ConstructName;
use Bakgul\Kernel\Tasks\ConvertCase;
use Bakgul\Kernel\Tasks\RequestTasks\ExtendRequestMap;
use Bakgul\ResourceCreator\Functions\ConvertValue;
use Bakgul\ResourceCreator\Functions\SetFolder;

class ExtendMap
{
    public static function _(array $request): array
    {
        $map = ExtendRequestMap::_($request);

        return [
            ...$map,
            'label' => ConvertValue::_($request['attr'], 'name'),
            'name' => $n = ConstructName::_($request['attr'], $map),
            'name_pascal' => ConvertCase::pascal($n),
            'container' => ConvertCase::kebab($map['container']),
            'folder' => SetFolder::_($request['attr']),
            'wrapper' => ConvertValue::_($request['attr'], 'wrapper'),
            'role' => '',
        ];
    }
}
