<?php

namespace Bakgul\ResourceCreator\Tasks;

use Bakgul\ResourceCreator\Functions\IsSharable;
use Bakgul\ResourceCreator\Functions\SetPrefix;
use Bakgul\ResourceCreator\Functions\UpdateParent;
use Bakgul\ResourceCreator\Functions\UpdatePathSchema;

class ExtendAttr
{
    public static function _(array $attr): array
    {
        return [
            ...$attr,
            'job' => 'resource',
            'sharing' => IsSharable::_($attr['variation']),
            'parent' => UpdateParent::_($attr),
            'path' => UpdatePathSchema::_($attr, 'path'),
            'path_schema' => UpdatePathSchema::_($attr, 'path_schema'),
            'prefix' => SetPrefix::_($attr['variation'])
        ];
    }
}