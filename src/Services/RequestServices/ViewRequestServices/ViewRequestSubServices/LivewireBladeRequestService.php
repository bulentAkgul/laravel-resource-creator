<?php

namespace Bakgul\ResourceCreator\Services\RequestServices\ViewRequestServices\ViewRequestSubServices;

use Bakgul\ResourceCreator\Services\RequestServices\ViewRequestServices\BladeViewRequestService;

class LivewireBladeRequestService extends BladeViewRequestService
{
    public function handle(array $request): array
    {
        return $request;
    }
}