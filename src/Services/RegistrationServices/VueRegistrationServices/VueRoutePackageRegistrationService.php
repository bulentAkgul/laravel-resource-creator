<?php

namespace Bakgul\ResourceCreator\Services\RegistrationServices\VueRegistrationServices;

use Bakgul\Kernel\Helpers\Settings;
use Bakgul\ResourceCreator\Services\RegistrationService;
use Bakgul\ResourceCreator\Services\RequestServices\RegistrationRequestServices\VuePackageRegistrationRequestService;

class VueRoutePackageRegistrationService extends RegistrationService
{
    private string $part;

    public function handle(array $request): void
    {
        if (Settings::standalone()) return;

        $this->part = 'children';

        $this->request = (new VuePackageRegistrationRequestService('route', $this->part))->handle($request);

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
            'repeat' => 2,
            'part' => $this->part,
            'bracket' => '[]'
        ];
    }
}