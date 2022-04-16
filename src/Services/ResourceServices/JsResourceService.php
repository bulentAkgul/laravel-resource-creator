<?php

namespace Bakgul\ResourceCreator\Services\ResourceServices;

use Bakgul\Kernel\Functions\CallClass;
use Bakgul\Kernel\Helpers\Arry;
use Bakgul\ResourceCreator\Services\RequestServices\JsRequestService;
use Bakgul\ResourceCreator\Services\ResourceService;

class JsResourceService extends ResourceService
{
    public function create(array $request): void
    {
        CallClass::_((new JsRequestService)->handle($request), 'resource', __NAMESPACE__);
    }

    private function service(array $attr)
    {
        $tail = 'JsResourceService';
        $base = __NAMESPACE__ . "\\{$tail}s";

        foreach ([$attr['app_type'], Arry::get($attr, 'framework')] as $type) {
            if (!$type) continue;
            
            $class = "{$base}\\{$this->setType($type)}{$tail}";

            if (class_exists("\\{$class}")) return new $class;
        }

        return null;
    }

    protected function setType(string $type)
    {
        return ucfirst(match($type) {
            'blade' => 'vanilla',
            default => $type
        });
    }
}