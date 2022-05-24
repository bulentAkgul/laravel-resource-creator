<?php

namespace Bakgul\ResourceCreator\Services\RequestServices\ViewRequestServices\ViewRequestSubServices;

use Bakgul\Kernel\Helpers\Path;
use Bakgul\Kernel\Helpers\Prevented;
use Bakgul\Kernel\Helpers\Settings;
use Bakgul\Kernel\Helpers\Text;
use Bakgul\ResourceCreator\Services\RequestServices\ViewRequestService;
use Illuminate\Support\Arr;

class RootBladeRequestService extends ViewRequestService
{
    private $class;

    public function handle(array $request): array
    {
        $this->class = $request['attr']['class'];

        return $this->index($request) ?? $this->layout($request);
    }

    private function index(array $request): ?array
    {
        if ($this->isNotIndex($request['attr'])) return null;

        $request['attr']['path'] = $this->setIndexPath();
        $request['attr']['stub'] = $this->setStub('index');

        return $request;
    }

    private function layout(array $request): array
    {
        $app = $request['attr']['app_type'] == 'blade' ? 'mpa' : 'spa';

        $request['attr']['path'] = Text::dropTail($request['attr']['path']);
        $request['attr']['stub'] = $this->setStub($app);

        $request['map']['extend'] = $request['attr']['parent']['name'];

        $request['map']['scripts'] = $this->livewire($request, 'Scripts');
        $request['map']['styles'] = $this->livewire($request, 'Styles');
        $request['map']['style'] = $this->style($request['map']);
        $request['map']['content'] = $this->content($request);
        $request['map']['head'] = $this->head($request);

        return $request;
    }

    private function isNotIndex(array $attr): bool
    {
        return $attr['name'] != 'index' || $attr['job'] != 'packagify';
    }

    private function setIndexPath()
    {
        return Path::glue([base_path(), 'resources', 'app', Settings::folders('view')]);
    }

    private function setStub($name)
    {
        return implode('.', [
            'blade', $name, $this->class ? 'class' : 'classless', 'stub'
        ]);
    }

    private function livewire($request, $suffix)
    {
        return Arr::get($request, 'attr.pipeline.options.livewire') ? "\n    @livewire{$suffix}" : '';
    }

    private function style($map)
    {
        if (Prevented::css()) return '';
        
        return PHP_EOL . str_repeat(' ', 8) . '<link rel="stylesheet" href="{{ asset(' . "'css/{$map['app']}.css'" . ') }}">'; 
    }

    private function content($request)
    {
        return match ($request['attr']['app_type']) {
            'vue' => '<div id="app">' . "\n    <router-view />\n" . '</div>',
            'blade' => $this->class ? '{{ $slot }}' : '@yield("page-content")',
            default => ''
        };
    }

    private function head($request)
    {
        return $this->class ? '{{ $head }}' : '@yield("head")';
    }
}