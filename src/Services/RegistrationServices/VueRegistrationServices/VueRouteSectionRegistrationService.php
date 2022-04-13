<?php

namespace Bakgul\ResourceCreator\Services\RegistrationServices\VueRegistrationServices;

use Bakgul\ResourceCreator\Services\RegistrationService;
use Bakgul\ResourceCreator\Services\RequestServices\RegistrationRequestServices\VueRouteSectionRegistrationRequestService;

class VueRouteSectionRegistrationService extends RegistrationService
{
    private $part = 'children';

    public function handle(array $request): void
    {
        $this->request = (new VueRouteSectionRegistrationRequestService)->handle($request);

        $this->register($this->lineSpecs(), $this->blockSpecs(), $this->part);
    }

    private function lineSpecs()
    {
        return [
            'start' => ['* IMPORTS *', 1],
            'end' => ['* ROUTES *', -1],
        ];
    }

    private function blockSpecs()
    {
        return [
            'start' => ["{$this->part}: [", 0],
            'end' => [']', 0],
            'part' => $this->part,
            'repeat' => 2,
            'bracket' => '[]',
            'isSortable' => true
        ];
    }
}
