<?php

namespace Bakgul\ResourceCreator\Functions\RequestFunctions;

use Bakgul\Kernel\Helpers\Arry;
use Bakgul\Kernel\Helpers\Settings;
use Bakgul\Kernel\Tasks\ConvertCase;

class SetWrapper
{
    public static function _(array $attr): string
    {
        return ConvertCase::_(Arry::get($attr, 'wrapper') ?? '', $attr['convention']);
    }
}