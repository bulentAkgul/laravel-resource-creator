<?php

namespace Bakgul\ResourceCreator\Services\RequestServices\RegistrationRequestServices;

use Bakgul\ResourceCreator\Services\RequestService;
use Bakgul\ResourceCreator\Vendors\Sass;

class SassCssRegistrationRequestService extends RequestService
{
    public function handle(array $request): array
    {
        $request['attr']['target_file'] = Sass::target($request);

        $request['map']['imports'] = Sass::forward($request['map']['name']);

        return $request;
    }
}
