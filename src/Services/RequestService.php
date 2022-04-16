<?php

namespace Bakgul\ResourceCreator\Services;

use Bakgul\Kernel\Tasks\RequestTasks\GenerateAttr;
use Bakgul\ResourceCreator\Tasks\RequestTasks\ExtendAttr;
use Bakgul\ResourceCreator\Functions\RequestFunctions\GenerateMap;
use Bakgul\ResourceCreator\ResourceCreator;

class RequestService extends ResourceCreator
{
    public function handle(array $request): array
    {
        return [
            'attr' => $a = ExtendAttr::_(GenerateAttr::_($request)),
            'map' => GenerateMap::_($a)
        ];
    }
}
