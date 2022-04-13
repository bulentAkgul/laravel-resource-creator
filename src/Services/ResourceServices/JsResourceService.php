<?php

namespace Bakgul\ResourceCreator\Services\ResourceServices;

use Bakgul\Kernel\Helpers\Arry;
use Bakgul\ResourceCreator\Services\RequestServices\JsRequestService;
use Bakgul\ResourceCreator\Services\ResourceService;

class JsResourceService extends ResourceService
{
    public function create(array $request): void
    {
        $request = (new JsRequestService)->handle($request);

        $this->service($request['attr'])?->create($request);
    }

    private function service(array $attr)
    {
        $tail = 'JsResourceService';
        $base = __NAMESPACE__ . "\\{$tail}s";

        foreach ([$attr['app_type'], Arry::get($attr, 'framework')] as $type) {
            if (!$type) continue;
            
            $class = "{$base}\\" . ucfirst($type) . $tail;

            if (class_exists("\\{$class}")) return new $class;
        }

        return null;
    }
}