<?php

namespace Bakgul\ResourceCreator\Services\RequestServices\JsRequestServices;

use Bakgul\Kernel\Helpers\Settings;
use Bakgul\Kernel\Tasks\ConvertCase;
use Bakgul\ResourceCreator\Services\RequestServices\JsRequestService;

class BladeJsRequestService extends JsRequestService
{
    public function handle(array $request): array
    {
        return [
            'attr' => $this->extendAttr($request),
            'map' => array_merge($this->extendMap($request), [
                'extends' => $this->setExtend($request['attr']),
            ]),
        ];
    }

    public function extendAttr(array $request): array
    {
        return array_merge($request['attr'], [
            'stub' => $this->setStub($request['attr']),
            'path' => $this->setPath($request),
            'file' => $this->setFile($request),
        ]);
    }

    private function setStub($attr)
    {
        return 'js.' . ($attr['pipeline']['options']['oop'] ? 'class' : '') . '.stub';
    }

    private function setExtend($attr)
    {
        return $attr['variation'] == 'section'
            ? ' extends ' . ConvertCase::_($attr['parent']['name'], $attr['convention'])
            : '';
    }
}