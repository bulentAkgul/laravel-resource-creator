<?php

namespace Bakgul\ResourceCreator\Services\RequestServices\CssRequestServices;

use Bakgul\ResourceCreator\Functions\RequestFunctions\SetFileName;
use Bakgul\ResourceCreator\Services\RequestServices\CssRequestService;
use Bakgul\ResourceCreator\Vendors\Sass;

class SassCssRequestService extends CssRequestService
{
    public function handle(array $request): array
    {
        $request['attr']['file'] = SetFileName::_($request);

        $request['map']['forwards'] = '';
        $request['map']['uses'] = Sass::use($request['attr']);
        $request['map']['class'] = Sass::class($request['map']['name']);

        return $request;
    }
}