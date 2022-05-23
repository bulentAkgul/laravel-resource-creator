<?php

namespace Bakgul\ResourceCreator\Functions;

use Bakgul\Kernel\Helpers\Arry;

class SetViewArgument
{
    public static function _(array $request)
    {
        $view = array_values(array_filter($request['attr']['queue'], fn ($x) => (
            $x['type'] == 'view' &&
            $x['variation'] == 'page' &&
            $x['name'] == $request['attr']['name']
        )))[0];

        return implode(':', [
            $request['map']['variation'],
            Arry::get($view, 'wrapper') ?: $view['name'],
            $request['map']['subs'],
        ]);
    }
}
