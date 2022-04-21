<?php

namespace Bakgul\ResourceCreator\Tasks;

use Bakgul\Kernel\Functions\ConstructName;
use Bakgul\Kernel\Helpers\Folder;
use Bakgul\Kernel\Helpers\Settings;
use Bakgul\Kernel\Tasks\ConvertCase;
use Bakgul\Kernel\Tasks\ExtendMap;
use Bakgul\ResourceCreator\Functions\ConvertValue;
use Bakgul\ResourceCreator\Functions\SetFolder;

class ExtendResourceMap
{
    public static function _(array $request): array
    {
        $map = ExtendMap::_($request);

        return [
            ...$map,
            'variation' => self::setVariation($request['attr']),
            'container' => self::setContainer($request['attr']),
            'label' => ConvertValue::_($request['attr'], 'name'),
            'name' => $n = ConstructName::_($request['attr'], $map),
            'name_pascal' => ConvertCase::pascal($n),
            'container' => ConvertCase::kebab($map['container']),
            'folder' => SetFolder::_($request['attr']),
            'wrapper' => ConvertValue::_($request['attr'], 'wrapper'),
            'role' => '',
        ];
    }

    private static function setVariation(array $attr): string
    {
        return ConvertCase::{$attr['convention']}(Settings::folders($attr['variation']), false);
    }

    private static function setContainer(array $attr)
    {
        $folder = Folder::get($attr['category']);

        return strtoupper($folder) == $folder ? $folder : ConvertCase::{$attr['convention']}($folder);
    }
}
