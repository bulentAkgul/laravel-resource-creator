<?php

namespace Bakgul\ResourceCreator\Services\RequestServices\RegistrationRequestServices;

use Bakgul\Kernel\Helpers\Path;
use Bakgul\Kernel\Helpers\Settings;
use Bakgul\Kernel\Helpers\Text;
use Bakgul\Kernel\Tasks\ConvertCase;
use Bakgul\ResourceCreator\Services\RequestService;
use Bakgul\ResourceCreator\Tasks\SetRelativePath;

class VuePackageRegistrationRequestService extends RequestService
{
    private $names = ['route' => 'router', 'store' => 'store'];
    
    public function __construct(private string $role, private string $part) {}

    public function handle(array $request): array
    {
        $request['attr']['target_file'] = $this->setTargetFile($request['attr']['app_folder']);
        
        $request['map']['package'] = ConvertCase::pascal($request['attr']['package']);
        $request['map']['imports'] = $this->setImports($request);
        $request['map'][$this->part] = "...{$request['map']['package']}()";

        return $request;
    }

    private function setTargetFile(string $app): string
    {
        return Path::glue([
            base_path(),
            'resources',
            Settings::folders('apps'),
            $app,
            Settings::folders('js'),
            "{$this->names[$this->role]}.js"
        ]);
    }

    private function setImports(array $request)
    {
        return implode(' ', [
            'import',
            $request['map']['package'],
            'from',
            Text::wrap($this->setRelativePath($request), 'dq')
        ]) . ';';
    }

    private function setRelativePath(array $request): string
    {
        return SetRelativePath::_(
            $request['attr']['target_file'],
            $request['attr']['path']
        ) . "/{$request['attr']['file']}";
    }
}
