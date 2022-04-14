<?php

namespace Bakgul\ResourceCreator\Services\RequestServices\RegistrationRequestServices;

use Bakgul\Kernel\Helpers\Text;
use Bakgul\ResourceCreator\Services\RequestService;

class SassCssRegistrationRequestService extends RequestService
{
    public function handle(array $request): array
    {
        $request['attr']['target_file'] = self::setTargetFile($request);

        $request['map']['imports'] = '@forward "./' . $request['map']['name'] . '";';

        return $request;
    }

    private function setTargetFile(array $request)
    {
        return str_replace(
            Text::append($request['map']['subs'], DIRECTORY_SEPARATOR),
            '',
            $request['attr']['path']
        ) . DIRECTORY_SEPARATOR. "_index.{$request['attr']['extension']}";
    }
}
