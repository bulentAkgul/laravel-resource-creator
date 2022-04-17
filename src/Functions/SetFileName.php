<?php

namespace Bakgul\ResourceCreator\Functions;

use Bakgul\Kernel\Tasks\ConvertCase;
use Bakgul\ResourceCreator\Tasks\SetCase;

class SetFileName
{
    public static function _(array $request): string
    {
        return ConvertCase::{SetCase::_($request['attr'])}($request['map']['name'])
             . ".{$request['attr']['extension']}";
    }
}