<?php

namespace Bakgul\ResourceCreator\Services\RequestServices\JsRequestServices;

use Bakgul\Kernel\Tasks\ConvertCase;
use Bakgul\ResourceCreator\Helpers\Pinia;
use Bakgul\ResourceCreator\Services\RequestServices\JsRequestService;
use Illuminate\Support\Str;

class VueJsRequestService extends JsRequestService
{
    private $store;

    public function __construct(private string $role) {}

    public function handle(array $request): array
    {
        $this->store = $request['attr']['pipeline']['options']['store'];

        return $this->extend([
            'attr' => $this->extendAttr($request),
            'map' => $this->extendMap($request),
        ]);
    }

    public function extendAttr(array $request): array
    {
        return array_merge($request['attr'], [
            'role' => $this->role,
            'stub' => $this->setStub($request),
            'file' => $this->setFile($request)
        ]);
    }

    private function setStub(array $request)
    {
        return 'js.vue.'. match(true) {
            $this->role == 'route' => 'route',
            $this->store == 'pinia' => 'pinia',
            $request['attr']['variation'] == 'section' => 'section',
            default => 'vuex',
        } .'.stub';
    }

    protected function setFile(array $request): string
    {
        return $this->role == 'store' && $this->store == 'pinia'
            ? Pinia::file($request['map']) . ".js"
            : "{$request['map']['name']}.js";
    }

    public function extendMap(array $request): array
    {
        return array_merge($request['map'], [
            'id' => ConvertCase::camel($request['map']['name']),
            'role' => ConvertCase::_($this->role, $request['attr']['convention'], false),
            'path' => $this->setPath($request),
            'imports' => '',
        ]);
    }

    protected function setPath(array $request): string
    {
        return str_contains(strtolower($request['map']['name']), 'index') ? '' : $this->slug($request);
    }

    private function slug(array $request): string
    {
        if ($request['attr']['task'] == 'index') return '';

        return Str::slug($request['attr']['variation'] == 'page'
            ? ConvertCase::kebab($request['map']['name'])
            : $this->getSlug($request)
        );
    }

    private function getSlug(array $request): string
    {
        $parts = ConvertCase::kebab($request['map']['name'], returnArray: true);
        $first = array_shift($parts);

        return implode('-', array_filter([
            ...$parts, $first == $request['attr']['parent']['name'] ? '' : $first
        ]));
    }

    public function extend(array $request): array
    {
        $request['attr']['path'] = $this->updatePath($request, $this->setSchema($request));

        return $request;
    }

    private function setSchema(array $request)
    {
        return $this->role == 'route'
            ? str_replace('{{ variation }}', '', $request['attr']['path_schema'])
            : $request['attr']['path_schema'];
    }
}
