<?php

namespace Bakgul\ResourceCreator\Services;

use Bakgul\Kernel\Tasks\MutateApp;
use Bakgul\Kernel\Tasks\RequestTasks\GenerateAttr;
use Bakgul\ResourceCreator\Tasks\ExtendAttr;
use Bakgul\ResourceCreator\ResourceCreator;

class RequestService extends ResourceCreator
{
    public function handle(array $request): array
    {
        return [
            'attr' => $a = ExtendAttr::_(GenerateAttr::_($request)),
            'map' => [
                ...MutateApp::update($a),
                'package' => $a['package'],
                'family' => $a['family'],
            ]
        ];
    }
}
