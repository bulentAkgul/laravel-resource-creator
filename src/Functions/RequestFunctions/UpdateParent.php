<?php

namespace Bakgul\ResourceCreator\Functions\RequestFunctions;

use Bakgul\Kernel\Helpers\Arry;

class UpdateParent
{
    public static function _(array $attr): array
    {
        return Arry::has('wrapper', $attr)
            ? [...$attr['parent'], 'name' => $attr['wrapper']]
            : $attr['parent'];
    }
}