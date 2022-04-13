<?php

namespace Bakgul\ResourceCreator\Services\RequestServices\ViewRequestServices;

use Bakgul\Kernel\Helpers\Settings;
use Bakgul\Kernel\Tasks\ConvertCase;
use Bakgul\ResourceCreator\Services\RequestServices\ViewRequestService;

class BladeViewRequestService extends ViewRequestService
{
    public function handle(array $request): array
    {
        $request['attr'] = $this->extendAttr($request);
        $request['map'] = $this->extendMap($request);

        return $request;
    }

    private function extendAttr(array $request): array
    {
        return array_merge($request['attr'], [
            'file' => $this->setFile($request),
            'stub' => $this->setStub($request),
            'path' => $this->setPath($request),
        ]);
    }

    private function setStub(array $request): string
    {
        return "blade.{$request['attr']['variation']}.stub";
    }

    protected function extendMap(array $request): array
    {
        return array_merge($request['map'], [
            'name_kebab' => ConvertCase::kebab($request['map']['name']),
            'extend' => '',
            'extend_page' => $this->setExtendPage($request['attr'])
        ]);
    }

    private function setExtendPage(array $attr): string
    {
        if ($attr['variation'] != 'section') return '';

        return $attr['variation'] == 'section'
            ? $this->bladePath($attr['path']) . '.' . ConvertCase::_(
                $attr['parent']['name'],
                $attr['convention']
            ) : '';
    }

    private function bladePath($path)
    {
        return str_replace(DIRECTORY_SEPARATOR, '.', explode(
            Settings::folders('view') . DIRECTORY_SEPARATOR,
            $path
        )[1]);
    }
}
