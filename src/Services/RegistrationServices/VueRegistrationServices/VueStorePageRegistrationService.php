<?php

namespace Bakgul\ResourceCreator\Services\RegistrationServices\VueRegistrationServices;

use Bakgul\Kernel\Helpers\Settings;
use Bakgul\ResourceCreator\Services\RegistrationService;
use Bakgul\ResourceCreator\Services\RequestServices\RegistrationRequestServices\VueStorePageRegistrationRequestService;

class VueStorePageRegistrationService extends RegistrationService
{
    private bool $sl;
    private string $part;

    public function handle(array $request): void
    {
        if (Settings::resources('vue.options.store') == 'pinia') return;
        
        $this->prepare();

        $this->request = (new VueStorePageRegistrationRequestService)->handle($request);

        $this->register($this->lineSpecs(), $this->blockSpecs(), $this->part);
    }

    private function prepare()
    {
        $this->sl = Settings::standalone('laravel');
        $this->part = $this->sl ? 'modules' : 'return';
    }

    private function lineSpecs()
    {
        return [
            'start' => ['* IMPORTS *', 1],
            'end' => ['export', -2],
        ];
    }

    private function blockSpecs()
    {
        return [
            'start' => $this->sl ? ["{$this->part}: {", 0] : ["export default", 1],
            'isSortable' => true,
            'repeat' => 1
        ];
    }
}
