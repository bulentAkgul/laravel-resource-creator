<?php

namespace Bakgul\ResourceCreator\Functions;

use Bakgul\Kernel\Helpers\Settings;

class GetExtensions
{
    public static function _(string $type): array
    {
        return Settings::resources("{$type}.options.extensions")
            ?? [Settings::resources("{$type}.extension") ?? $type];
    }
}