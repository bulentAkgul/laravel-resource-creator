<?php

namespace Bakgul\ResourceCreator\Services\ResourceServices\CssResourceServices\CssResourceSubServices;

use Bakgul\FileContent\Functions\CreateFile;
use Bakgul\ResourceCreator\Services\RequestServices\CssRequestServices\CssRequestSubServices\RootSassCssResourceService;

class RootSassResourceService
{
    public function create(array $request): void
    {
        CreateFile::_((new RootSassCssResourceService)->handle($request));
    }
}