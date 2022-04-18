<?php

namespace Bakgul\ResourceCreator\Functions;

class SetBlockSpecs
{
    public static function _(array $specs)
    {
        return array_merge([
            'end' => ['}', 0],
            'isStrict' => true,
            'repeat' => 1,
            'isSortable' => false
        ], $specs);
    }
}
