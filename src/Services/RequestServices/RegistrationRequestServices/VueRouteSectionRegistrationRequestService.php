<?php

namespace Bakgul\ResourceCreator\Services\RequestServices\RegistrationRequestServices;

use Bakgul\Kernel\Helpers\Path;
use Bakgul\ResourceCreator\Functions\SetFileName;
use Bakgul\ResourceCreator\Services\RequestService;

class VueRouteSectionRegistrationRequestService extends RequestService
{
    public function handle(array $request): array
    {
        return [
            'attr' => $a = array_merge($request['attr'], [
                'target_file' => Path::glue([
                    $request['attr']['path'], SetFileName::_($request, true)
                ])
            ]),
            'map' => array_merge($request['map'], [
                'imports' => 'import ' . $request['map']['name'] . ' from "./' . $request['map']['name'] . '"',
                'children' => "{$request['map']['name']}()"
            ])
        ];
    }
}
