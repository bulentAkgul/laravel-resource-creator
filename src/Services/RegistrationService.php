<?php

namespace Bakgul\ResourceCreator\Services;

use Bakgul\ResourceCreator\ResourceCreator;
use Bakgul\ResourceCreator\Tasks\Register;

class RegistrationService extends ResourceCreator
{
    protected array $request;

    protected function setRequest(array $request): void
    {
        $this->request = $request;
    }

    protected function register(array $lineSpecs, array $blockSpecs, string $key, ?string $only = null)
    {
        Register::_($this->request, $lineSpecs, $blockSpecs, $key, $only);
    }
}
