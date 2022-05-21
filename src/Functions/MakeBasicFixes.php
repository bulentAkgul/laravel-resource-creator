<?php

namespace Bakgul\ResourceCreator\Functions;

use Bakgul\Kernel\Helpers\Text;

class MakeBasicFixes
{
    public static function _($request): array
    {
        $request['attr']['path'] = Text::dropTail($request['attr']['path']);
        $request['attr']['file'] = "{$request['attr']['app_folder']}.{$request['attr']['extension']}";

        return $request;
    }
}