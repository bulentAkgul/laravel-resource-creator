<?php

namespace Bakgul\ResourceCreator\Services\RegistrationServices\VueRegistrationServices;

use Bakgul\ResourceCreator\Services\RegistrationService;
use Bakgul\ResourceCreator\Services\RequestServices\RegistrationRequestServices\VueViewPageRegistrationRequestService;

class VueViewPageRegistrationService extends RegistrationService
{
    public function handle(array $request): void
    {
        if ($this->isNotRegistrable($request['attr'])) return;

        $this->request = (new VueViewPageRegistrationRequestService)->handle($request);

        $this->register($this->lineSpecs(), [], '', 'line');
    }

    private function isNotRegistrable(array $attr)
    {
        return false;
    }

    private function lineSpecs()
    {
        return [
            'start' => ['* IMPORTS *', 1],
            'end' => ['* ROUTES *', -1],
        ];
    }
}
