<?php

namespace Bakgul\ResourceCreator\Tasks\RequestTasks;

use Bakgul\ResourceCreator\Functions\RequestFunctions\IsSharable;
use Bakgul\ResourceCreator\Functions\RequestFunctions\SetPrefix;
use Bakgul\ResourceCreator\Functions\RequestFunctions\UpdateParent;
use Bakgul\ResourceCreator\Functions\RequestFunctions\UpdatePathSchema;

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