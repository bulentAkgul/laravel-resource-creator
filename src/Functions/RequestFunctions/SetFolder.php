<?php

namespace Bakgul\ResourceCreator\Functions\RequestFunctions;

use Bakgul\Kernel\Helpers\Arry;
use Bakgul\Kernel\Helpers\Settings;
use Bakgul\Kernel\Tasks\ConvertCase;

class SetFolder
{
    public static function _(array $attr): string
    {
        if (Arry::has('folder', $attr)) return ConvertCase::{$attr['convention']}($attr['folder']);

        return in_array($attr['variation'], Settings::resourceOptions('section_parents'))
            ? $attr['name']
            : ($attr['variation'] == 'section' ? ($attr['parent']['name'] ?: $attr['name']) : '');
    }
}