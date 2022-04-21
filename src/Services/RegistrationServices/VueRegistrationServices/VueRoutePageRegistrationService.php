<?php

namespace Bakgul\ResourceCreator\Services\RegistrationServices\VueRegistrationServices;

use Bakgul\Kernel\Helpers\Settings;
use Bakgul\ResourceCreator\Services\RegistrationService;
use Bakgul\ResourceCreator\Services\RequestServices\RegistrationRequestServices\VueRoutePageRegistrationRequestService;

class VueRoutePageRegistrationService extends RegistrationService
{
    private bool $sl;
    private string $part;

    public function handle(array $request): void
    {
        $this->sl = Settings::standalone('laravel');
        $this->part = $this->sl ? 'children' : 'return';

        $this->request = (new VueRoutePageRegistrationRequestService)->handle($request);

        $this->register($this->lineSpecs(), $this->blockSpecs(), $this->part);
    }

    private function lineSpecs()
    {
        return [
            'start' => ['* IMPORTS *', 1],
            'end' => [$this->sl ? 'const routes = [' : 'export default {', -2],
        ];
    }

    private function blockSpecs()
    {
        return [
            'start' => $this->sl ? ["{$this->part}: [", 0] : ["export default", 1],
            'end' => [']', 0],
            'part' => $this->part,
            'bracket' => '[]'
        ];
    }
}