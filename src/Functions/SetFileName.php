<?php

namespace Bakgul\ResourceCreator\Functions;

use Bakgul\Kernel\Tasks\ConvertCase;
use Bakgul\ResourceCreator\Tasks\SetCase;

class SetFileName
{
    public static function _(array $request, bool $isParent = false): string
    {
        return ConvertCase::{SetCase::_($request['attr'])}(
            $isParent ? $request['attr']['parent']['name'] : $request['map']['name']
        ) . ".{$request['attr']['extension']}";
    }
}
