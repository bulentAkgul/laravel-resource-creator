<?php

namespace Bakgul\ResourceCreator\Services\RequestServices\RegistrationRequestServices;

use Bakgul\Kernel\Helpers\Path;
use Bakgul\Kernel\Helpers\Settings;
use Bakgul\ResourceCreator\Services\RequestService;

class VueRoutePageRegistrationRequestService extends RequestService
{
    public function handle(array $request): array
    {
        return [
            'attr' => array_merge($request['attr'], [
                'target_file' => $this->setTargetFile($request['attr']['path']),
            ]),
            'map' => array_merge($request['map'], [
                'imports' => $this->setImports($request),
                Settings::standalone('laravel') ? 'children' : 'return' => "{$request['map']['name']}()"
            ])
        ];
    }

    private function setTargetFile(string $path): string 
    {
        $folder = Settings::folders('js');
        $file = Settings::standalone('laravel') ? 'router' : 'routes';

        return Path::glue([explode(DIRECTORY_SEPARATOR . $folder, $path)[0], $folder, "{$file}.js"]);
    }

    private function setImports(array $request)
    {
        return 'import ' . $request['map']['name'] . ' from "./' . $this->setRelativePath($request) . '";';
    }

    private function setRelativePath(array $request): string
    {
        return Path::glue([
            $request['map']['role'], $request['map']['name'], $request['map']['name']
        ], '/');
    }
}