<?php

namespace Bakgul\ResourceCreator\Functions;

use Bakgul\Kernel\Helpers\Arry;
use Bakgul\Kernel\Tasks\ConvertCase;

class ConvertValue
{
    public static function _(array|string $input, ?string $mod = null, ?bool $isSingular = null): string
    {
        return ConvertCase::_(
            is_array($input) ? Arry::get($input, $mod) ?? '' : $input,
            is_array($input) ? Arry::get($input, 'convention') : ($mod ?: 'pascal'),
            $isSingular
        );
    }
}
