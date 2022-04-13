<?php

namespace Bakgul\ResourceCreator\Services\ResourceServices\ViewResourceServices;

use Bakgul\Kernel\Helpers\Arry;
use Bakgul\Kernel\Helpers\Path;
use Bakgul\ResourceCreator\Services\RequestServices\ViewRequestServices\VueViewRequestService;
use Bakgul\ResourceCreator\Services\ResourceServices\ViewResourceService;
use Illuminate\Support\Str;

class VueViewResourceService extends ViewResourceService
{
    public function create(array $request): void
    {
        $request = (new VueViewRequestService)->handle($request);

        $this->callClass($request, $this->class($request['attr'], __NAMESPACE__)) ?: $this->createFile($request);

        $this->removeOptionsAPI($request['attr']);
    }

    private function removeOptionsAPI(array $attr): void
    {
        $path = Path::glue([$attr['path'], $attr['file']]);

        $content = file_get_contents($path);

        file_put_contents($path, str_replace(array_filter([
            $this->block($content, $attr), '{{{{', '}}}}'
        ]), '', $content));
    }

    private function block($content, $attr)
    {
        return Arry::get($attr['pipeline']['options'], 'compositionAPI')
            ? Str::between($content, '{{{{', '}}}}')
            : '';
    }
}
