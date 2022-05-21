<?php

namespace Bakgul\ResourceCreator\Services\RequestServices\JsRequestServices\JsRequestSubServices;

use Bakgul\Kernel\Helpers\Path;
use Bakgul\Kernel\Helpers\Settings;
use Bakgul\Kernel\Helpers\Text;
use Bakgul\Kernel\Tasks\ConvertCase;
use Bakgul\ResourceCreator\Services\RequestServices\ViewRequestService;

class RootVueJsRequestService extends ViewRequestService
{
    public static function main(array $request): array
    {
        $request['attr']['path'] = Text::dropTail($request['attr']['path'], length: 2);

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
            ? "import { router } from './router';"
            : '', "\n");
    }

    private static function uses($map): string
    {
        $store = str_contains($map['store'], 'pinia') ? 'createPinia()' : (str_contains($map['store'], 'stores') ? 'stores' : '');
        $route = $map['route'] ? 'router' : '';

        return implode(PHP_EOL, array_filter([
            $store ? "\napp.use({$store})" : '',
            $route ? "\napp.use({$route})" : '',
        ]));
    }

    public static function vuex($request): array
    {
        $request['attr']['path'] = self::dropTail($request['attr']['path']);
        $request['attr']['file'] = 'stores.js';
        $request['attr']['stub'] = 'js.vue.stores.stub';

        return $request;
    }

    public static function pinia($request): array
    {
        $request['attr']['job'] = 'resource';
        $request['attr']['stub'] = 'js.vue.pinia.stub';
        $request['attr']['path'] = self::dropTail($request['attr']['path']);
        $request['attr']['file'] = "use{$request['map']['name_pascal']}." . Settings::resources('pinia.extension');

        $request['map']['id'] = lcfirst($request['map']['name_pascal']);

        return $request;
    }

    public static function router($request): array
    {
        $request['attr']['path'] = self::dropTail($request['attr']['path']);
        $request['attr']['file'] = 'router.js';
        $request['attr']['stub'] = 'js.vue.router.stub';

        $request['map']['container'] = Settings::folders('view');
        $request['map']['route_group'] = Settings::apps("{$request['attr']['app_key']}.route_group");

        return $request;
    }

    private static function dropTail(string $path)
    {
        return Text::dropTail($path, length: 2);
    }
}
