<?php

namespace Bakgul\ResourceCreator\Services\RequestServices\ViewRequestServices\ViewRequestSubServices;

use Bakgul\ResourceCreator\Services\RequestServices\ViewRequestService;

class LayoutVueRequestService extends ViewRequestService
{
    public function handle(array $request): array
    {
        $request['map']['script'] = '';
        $request['map']['layout'] = '';

        return $request;
    }
}