<?php

namespace Bakgul\ResourceCreator\Services\RequestServices\RegistrationRequestServices;

use Bakgul\Kernel\Helpers\Path;
use Bakgul\ResourceCreator\Services\RequestService;

class VueStoreSectionRegistrationRequestService extends RequestService
{
    public function handle(array $request): array
    {
        $request['attr']['target_file'] = Path::glue([$request['attr']['path'], "{$this->setParent($request['attr'])}.js"]);

        return $request;
    }

    public function extend(array $request, string $part): array
    {
        $request['map']['imports'] = $this->setImports($request['map'], $part);
        $request['map'][$part] = $this->setCodeBlock($request['map'], $part);

        return $request;
    }

    private function setImports(array $map, string $part)
    {
        return 'import ' . $map['name'] . ucfirst($part) . ' from "./' . $map['name'] . '";';
    }

    private function setCodeBlock(array $map, string $part): string
    {
        return "...{$map['name']}"  . ucfirst($part) . '()';
    }
}