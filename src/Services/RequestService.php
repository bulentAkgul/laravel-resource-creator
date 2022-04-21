<?php

namespace Bakgul\ResourceCreator\Services;

use Bakgul\Kernel\Tasks\MutateApp;
use Bakgul\Kernel\Tasks\GenerateAttr;
use Bakgul\Kernel\Tasks\GenerateMap;
use Bakgul\ResourceCreator\Tasks\ExtendAttr;
use Bakgul\ResourceCreator\ResourceCreator;

class RequestService extends ResourceCreator
{
    public function handle(array $request): array
    {
        return [
            'attr' => $a = ExtendAttr::_(GenerateAttr::_($request)),
            'map' => [...GenerateMap::_($a), ...MutateApp::update($a)],
        ];
    }
}
