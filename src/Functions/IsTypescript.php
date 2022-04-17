<?php

namespace Bakgul\ResourceCreator\Functions;

use Bakgul\Kernel\Helpers\Settings;
use Illuminate\Support\Arr;

class IsTypescript
{
    public static function _(array $attr): bool
    {
        return Arr::get($attr, 'pipeline.options.ts')
            ?? Settings::resources("{$attr['type']}.extension") === 'ts'
            || Settings::resources("{$attr['type']}.options.ts");
    }
}