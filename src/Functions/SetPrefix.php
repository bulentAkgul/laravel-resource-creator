<?php

namespace Bakgul\ResourceCreator\Functions;

use Bakgul\Kernel\Helpers\Settings;

class SetPrefix
{
    public static function _(string $variation): string
    {
        return Settings::main('use_prefix')
            ? Settings::prefixes($variation) ?? ''
            : '';
    }
}
