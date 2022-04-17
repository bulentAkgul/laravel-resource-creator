<?php

namespace Bakgul\ResourceCreator\Domains;

use Bakgul\Kernel\Helpers\Settings;
use Bakgul\ResourceCreator\Vendors\VueRouter;

class VueRoute
{
    private $router;

    public function __construct(private array $request)
    {
        $this->router = match ($request['attr']['router']) {
            'vue-router' => new VueRouter,
            default => null
        };
    }

    public function route(array $request): string
    {
        return $this->isNotRoutable($request['attr'])
            ? $this->router->route($request)
            : '';
    }

    private function isNotRoutable(array $attr): bool
    {
        return !in_array($attr['variation'], Settings::resourceOptions('levels.high'))
            || in_array(Settings::apps($attr['router']), Settings::prohibitives('route'));
    }

    public function stub()
    {
        return $this->router->stub();
    }

    public function file(array $request): string
    {
        return $this->router->file($request);
    }

    public function schema(array $attr): string
    {
        return $this->router->schema($attr);
    }
}
