<?php

namespace Bakgul\ResourceCreator\Vendors;

use Bakgul\ResourceCreator\Functions\RequestFunctions\ConvertValue;

class Vanilla
{
    public function setStub(array $attr): string
    {
        return 'js.' . ($attr['pipeline']['options']['oop'] ? 'class' : '') . '.stub';
    }

    public function extend(array $attr): string
    {
        return $attr['variation'] == 'section'
            ? ' extends ' . ConvertValue::_($attr['parent'], 'name')
            : '';
    }
}