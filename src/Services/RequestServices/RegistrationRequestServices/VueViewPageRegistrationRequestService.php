<?php

namespace Bakgul\ResourceCreator\Services\RequestServices\RegistrationRequestServices;

use Bakgul\Kernel\Helpers\Path;
use Bakgul\Kernel\Helpers\Settings;
use Bakgul\Kernel\Helpers\Text;
use Bakgul\Kernel\Tasks\ConvertCase;
use Bakgul\ResourceCreator\Services\RequestService;
use Bakgul\ResourceCreator\Tasks\SetRelativePath;

class VueViewPageRegistrationRequestService extends RequestService
{
    public function handle(array $request): array
    {
        $request['attr']['target_file'] = $this->setTargetFile($request);
        $request['map']['imports'] = $this->setImport($request);
        $request['map']['components'] = $request['map']['name'];

        return $request;
    }

    private function setTargetFile(array $request)
    {
        $s = DIRECTORY_SEPARATOR;
        $m = $request['map'];

        return str_replace(
            ["{$s}{$m['container']}", "{$s}{$m['variation']}"],
            [$s . Settings::folders('js'), "{$s}Routes"],
            $request['attr']['path']
        ) . "{$s}index.js";
    }

    private function setImport(array $request): string
    {
        return implode(' ', [
            'import',
            ConvertCase::pascal($request['map']['name']),
            'from',
            ''
        ]) . Text::wrap($this->setRelativePath($request['attr']), 'dq');
    }

    private function setRelativePath(array $attr): string
    {
        return Path::glue([
            SetRelativePath::_(
                $attr['target_file'],
                $attr['path']
            ), $attr['file']
        ]);
    }
}
