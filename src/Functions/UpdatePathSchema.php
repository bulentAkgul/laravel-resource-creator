<?php

namespace Bakgul\ResourceCreator\Functions;

use Bakgul\Kernel\Functions\UpdateSchema;
use Bakgul\Kernel\Helpers\Arry;

class UpdatePathSchema
{
    public static function _(array $attr, string $key): string
    {
        return Arry::has('wrapper', $attr)
            ? UpdateSchema::_($attr[$key], 'folder', 'wrapper')
            : $attr[$key];
    }
}
