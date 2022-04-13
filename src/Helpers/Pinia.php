<?php

namespace Bakgul\ResourceCreator\Helpers;

use Bakgul\Kernel\Helpers\Settings;
use Bakgul\Kernel\Helpers\Text;
use Bakgul\ResourceCreator\Tasks\SetPiniaImport;
use Illuminate\Support\Str;

class Pinia
{
    public static function file($map)
    {
        $schema = Settings::resources('pinia.name_schema');
        $suffix = Str::after($schema, '}}');

        return Text::replaceByMap($map, str_replace($suffix, '', $schema));
    }

    public static function name($map)
    {
        return Text::replaceByMap($map, Settings::resources('pinia.name_schema'));
    }

    public static function mapFunction($map)
    {
        return self::name($map) . ", []";
    }

    public static function import(array $request)
    {
        return $request['attr']['pipeline']['options']['store'] == 'pinia'
            ? SetPiniaImport::_($request)
            : '';
    }
}