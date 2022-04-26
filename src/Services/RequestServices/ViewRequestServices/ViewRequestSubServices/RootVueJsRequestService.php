<?php

namespace Bakgul\ResourceCreator\Services\RequestServices\ViewRequestServices\ViewRequestSubServices;

use Bakgul\Kernel\Helpers\Path;
use Bakgul\Kernel\Helpers\Settings;
use Bakgul\Kernel\Helpers\Text;
use Bakgul\Kernel\Tasks\ConvertCase;
use Bakgul\ResourceCreator\Services\RequestServices\ViewRequestService;

class RootVueJsRequestService extends ViewRequestService
{
    public function handle(array $request): array
    {
        $request['attr']['path'] = Text::dropTail($request['attr']['path'], length: 3);
        $request['attr']['file'] = implode('.', [
            $request['attr']['app_folder'],
            $request['attr']['pipeline']['options']['ts'] ? 'ts' : Settings::resources('js.extension') ?? 'js'
        ]);

        if ($request['attr']['router'] == 'inertia') {
            $request['attr']['stub'] = 'js.vue.inertia.stub';
            $request['map']['container'] = Settings::folders('view');
            $request['map']['relative_path'] = self::relativePath($request['map']['container']);
        } else {
            $request['attr']['stub'] = 'js.vue.app.stub';
            $request['map']['store'] = self::store($request['attr']);
            $request['map']['route'] = self::route($request['attr']);
            $request['map']['uses'] = self::uses($request['map']);
        }

        return $request;
    }

    private static function relativePath(string $container): string
    {
        return Path::glue([
            $container,
            ConvertCase::_(Settings::folders('pages'), Settings::resources('vue.convention'))
        ], '/');
    }

    private static function store($app): string
    {
        $store = Settings::resources("{$app['type']}.options.store");

        $import = $store == 'vuex'
            ? "import { stores } from './" . Settings::folders('js') . "/stores';"
            : ($store == 'pinia' ? "import { createPinia } from 'pinia'" : '');

        return Text::append($import, "\n");
    }

    private static function route($app): string
    {
        return Text::append($app['router'] == 'vue-router'
            ? "import { router } from './" . Settings::folders('js') . "/router';"
            : '', "\n");
    }

    private static function uses($map): string
    {
        $store = str_contains($map['store'], 'pinia') ? 'createPinia()' : (str_contains($map['store'], 'stores') ? 'stores' : '');
        $route = $map['route'] ? 'router' : '';

        return implode(PHP_EOL, array_filter([
            $store ? "\napp.use({$store})" : '',
            $route ? "\napp.use({$store})" : '',
        ]));
    }
}
