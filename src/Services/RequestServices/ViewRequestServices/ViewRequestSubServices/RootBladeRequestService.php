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

        $request['attr']['path'] = Text::dropTail($request['attr']['path'], length: 2);
        $request['attr']['stub'] = "blade.{$app}.stub";

        $request['map']['extend'] = $request['attr']['parent']['name'];

        $request['map']['scripts'] = Arr::get($request, 'attr.pipeline.options.livewire') ? '@livewireScripts' : '';
        $request['map']['styles'] = Arr::get($request, 'attr.pipeline.options.livewire') ? '@livewireStyles' : '';
        $request['map']['content'] = match ($request['attr']['app_type']) {
            'vue' => "\n    <router-view />\n",
            default => ''
        };
        
        return $request;
    }
}