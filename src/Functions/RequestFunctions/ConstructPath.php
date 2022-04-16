<?php

namespace Bakgul\ResourceCreator\Functions\RequestFunctions;

use Bakgul\Kernel\Helpers\Text;

class ConstructPath
{
    public static function _(array $request, string $glue = DIRECTORY_SEPARATOR): string
    {
        return Text::replaceByMap($request['map'], $request['attr']['path'], true, $glue);
    }
}