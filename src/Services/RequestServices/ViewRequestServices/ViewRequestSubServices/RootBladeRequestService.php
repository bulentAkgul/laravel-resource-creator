<?php

namespace Bakgul\ResourceCreator\Services\RequestServices\ViewRequestServices\ViewRequestSubServices;

use Bakgul\Kernel\Helpers\Text;
use Bakgul\ResourceCreator\Services\RequestServices\ViewRequestService;
use Illuminate\Support\Arr;

class RootBladeRequestService extends ViewRequestService
{
    public function handle(array $request): array
    {
        $app = $request['attr']['app_type'] == 'blade' ? 'mpa' : 'spa';

        $request['attr']['path'] = Text::dropTail($request['attr']['path']);
        $request['attr']['stub'] = "blade.{$app}.stub";

        $request['map']['extend'] = $request['attr']['parent']['name'];

        $request['map']['scripts'] = $this->livewire($request, 'Scripts');
        $request['map']['styles'] = $this->livewire($request, 'Styles');
        $request['map']['content'] = $this->content($request);
        $request['map']['head'] = $this->head($request);

        return $request;
    }

    private function livewire($request, $suffix)
    {
        return Arr::get($request, 'attr.pipeline.options.livewire') ? "\n    @livewire{$suffix}" : '';
    }

    private function content($request)
    {
        return match ($request['attr']['app_type']) {
            'vue' => '<div id="app">' . "\n    <router-view />\n" . '</div>',
            'blade' => $request['attr']['class'] ? '{{ $slot }}' : '@yield("page-content")',
            default => ''
        };
    }

    private function head($request)
    {
        return $request['attr']['class'] ? '{{ $head }}' : '@yield("head")';
    }
}