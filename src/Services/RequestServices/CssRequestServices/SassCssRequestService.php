<?php

namespace Bakgul\ResourceCreator\Services\RequestServices\CssRequestServices;

use Bakgul\ResourceCreator\Functions\SetFileName;
use Bakgul\ResourceCreator\Services\RequestServices\CssRequestService;
use Bakgul\ResourceCreator\Vendors\Sass;

class SassCssRequestService extends CssRequestService
{
    public function handle(array $request): array
    {
        $sass = new Sass;

        $request['attr']['file'] = SetFileName::_($request);
        $request['attr']['stub'] = $sass->stub();

        $request['map']['forwards'] = '';
        $request['map']['uses'] = $sass->use($request['attr']);
        $request['map']['class'] = $sass->class($request['map']['name']);

        return $request;
    }
}