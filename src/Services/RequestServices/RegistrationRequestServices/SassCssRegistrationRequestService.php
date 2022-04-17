<?php

namespace Bakgul\ResourceCreator\Services\RequestServices\RegistrationRequestServices;

use Bakgul\ResourceCreator\Services\RequestService;
use Bakgul\ResourceCreator\Vendors\Sass;

class SassCssRegistrationRequestService extends RequestService
{
    public function handle(array $request): array
    {
        $sass = new Sass;

        $request['attr']['target_file'] = $sass->target($request);

        $request['map']['imports'] = $sass->forward($request['map']['name']);

        return $request;
    }
}
