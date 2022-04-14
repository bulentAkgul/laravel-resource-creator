<?php

namespace Bakgul\ResourceCreator\Services\RegistrationServices\CssRegistrationServices;

use Bakgul\ResourceCreator\Services\RegistrationService;
use Bakgul\ResourceCreator\Services\RequestServices\RegistrationRequestServices\SassCssRegistrationRequestService;
use Bakgul\ResourceCreator\Tasks\CreateStyleIndexFiles;

class SassCssRegistrationService extends RegistrationService
{
    public function handle(array $request): void
    {
        $this->request = (new SassCssRegistrationRequestService)->handle($request);

        CreateStyleIndexFiles::sass($this->request);

        $this->register($this->lineSpecs(), [], '', 'line');
    }

    private function lineSpecs()
    {
        return [
            'start' => ['@forward', 0],
            'end' => ['@forward', 0],
            'isEmpty' => true
        ];
    }
}
