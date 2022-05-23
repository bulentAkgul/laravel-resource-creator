<?php

namespace Bakgul\ResourceCreator\Tasks;

use Bakgul\Kernel\Functions\CreateFileRequest;
use Bakgul\Kernel\Tasks\SimulateArtisanCall;
use Bakgul\ResourceCreator\Functions\SetViewArgument;

class CreateLivewireClass
{
    public static function _(array $request)
    {
        if ($request['attr']['extra'] != 'livewire') return;

        (new SimulateArtisanCall)(CreateFileRequest::_([
            'name' => $request['map']['name_kebab'],
            'type' => 'livewire',
            'package' => $request['attr']['package'],
            'app' => $request['attr']['app'],
            'views' => SetViewArgument::_($request)
        ]));
    }
}