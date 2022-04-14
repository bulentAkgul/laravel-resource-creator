<?php

namespace Bakgul\ResourceCreator\Services;

use Bakgul\Kernel\Concerns\HasRequest;
use Bakgul\Kernel\Helpers\Path;
use Bakgul\FileContent\Functions\MakeFile;
use Bakgul\FileContent\Tasks\CompleteFolders;
use Bakgul\Kernel\Services\NotExpectedTypeService;
use Bakgul\ResourceCreator\ResourceCreator;
use Bakgul\ResourceCreator\Services\ResourceServices\CssResourceService;
use Bakgul\ResourceCreator\Services\ResourceServices\JsResourceService;
use Bakgul\ResourceCreator\Services\ResourceServices\ViewResourceService;

class ResourceService extends ResourceCreator
{
    use HasRequest;

    public function create(array $request): void
    {
        $request = (new RequestService)->handle($request);

        $this->service($request['attr']['type'])->create($request);
    }

    private function service(string $type): ?object
    {
        return match ($type) {
            'view' => new ViewResourceService,
            'js' => new JsResourceService,
            'css' => new CssResourceService,
            default => new NotExpectedTypeService
        };
    }

    public function createFile($request)
    {
        if ($this->isFileNotCreatable($request['attr'])) return;

        CompleteFolders::_($request['attr']['path']);

        MakeFile::_($request);
    }

    protected function isFileNotCreatable(array $attr): bool
    {
        return !$attr['force'] && file_exists(Path::glue([$attr['path'], $attr['file']]));
    }

    protected function callClass(array $request, string $class): bool
    {
        if (!class_exists($class)) return false;
        
        (new $class)->create($request);

        return true;
    }
}
