<?php

namespace Bakgul\ResourceCreator\Services\RegistrationServices\VueRegistrationServices;

use Bakgul\Kernel\Helpers\Settings;
use Bakgul\ResourceCreator\Services\RegistrationService;
use Bakgul\ResourceCreator\Services\RequestServices\RegistrationRequestServices\VueViewSectionRegistrationRequestService;

class VueViewSectionRegistrationService extends RegistrationService
{
    private $part = 'components';

    public function handle(array $request): void
    {
        $this->request = (new VueViewSectionRegistrationRequestService)->handle($request);

        $this->register($this->lineSpecs(), $this->blockSpecs(), $this->part, $this->only());
    }

    private function lineSpecs()
    {
        return [
            'start' => ['<script', 1],
            'end' => [!$this->only() ? 'export default {' : '</script>', -1],
        ];
    }

    private function blockSpecs()
    {
        return [
            'start' => ["{$this->part}: {", 0],
            'part' => $this->part,
            'isSortable' => true
        ];
    }

    private function only()
    {
        return Settings::resources('vue.options.compositionAPI') ? 'line' : null;
    }
}
