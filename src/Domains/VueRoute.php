<?php

namespace Bakgul\ResourceCreator\Domains;

use Bakgul\Kernel\Helpers\Arry;
use Bakgul\Kernel\Helpers\Settings;
use Bakgul\Kernel\Helpers\Text;
use Bakgul\Kernel\Tasks\ConvertCase;
use Bakgul\ResourceCreator\Tasks\SetRelativePath;
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

    public function route(array $attr): string
    {
        if ($this->isNotRoutable($attr)) return '';

        $task = Arry::has('wrapper', $attr) ? $attr['name'] : $attr['task'];
        $schema = $task ? Settings::router('schemas.' . $task) : '';

        if ($attr['variation'] == 'section') return $schema;

        return Settings::resourceOptions('tasks_as_sections')
            ? $attr['name']
            : implode('/', array_filter([$attr['wrapper'], $schema]));
    }

    public function imports(array $request): string
    {
        if (Settings::resources('vue.options.code_splitting')) return '';

        return 'import '
            . $request['map']['name_pascal']
            . ' from "'
            . $this->setRelativePath($request)
            . '.vue";';
    }

    public function component(array $request): string
    {
        if (!Settings::resources('vue.options.code_splitting')) return $request['map']['name_pascal'];

        return '() => import(/* webpackChunkName: "'
            . ConvertCase::kebab($request['map']['name'])
            . '" */ "'
            . $this->setRelativePath($request)
            . '.vue")';
    }

    public function setRelativePath(array $request): string
    {
        return SetRelativePath::_($request['attr']['path'], $this->setTargetPath($request))
            . Text::append($request['map']['name_pascal']);
    }

    private function setTargetPath(array $request): string
    {
        return str_replace(
            [
                Text::inject(Settings::folders('js')), 
                Text::inject($request['map']['role'])
            ],
            [
                Text::inject(Settings::folders('view')),
                Text::inject($this->viewFolder())
            ],
            $request['attr']['path']
        );
    }

    private function viewFolder()
    {
        return ConvertCase::_('pages', Settings::resources('vue.convention'));
    }
}
