<?php

namespace Bakgul\ResourceCreator\Functions\RequestFunctions;

use Bakgul\Kernel\Tasks\MutateApp;

class GenerateMap
{
    public static function _(array $attr): array
    {
        return [
            ...MutateApp::update($attr),
            'package' => $attr['package'],
            'family' => $attr['family'],
        ];
    }
}