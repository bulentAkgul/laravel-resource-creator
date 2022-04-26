<?php

namespace Bakgul\ResourceCreator\Services\RequestServices\ViewRequestServices\ViewRequestSubServices;

use Bakgul\Kernel\Helpers\Text;
use Bakgul\Kernel\Tasks\ConvertCase;
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