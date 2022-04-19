<?php

namespace Bakgul\ResourceCreator\Vendors;

use Bakgul\Kernel\Helpers\Arry;
use Bakgul\Kernel\Helpers\Settings;
use Bakgul\Kernel\Helpers\Text;
use Bakgul\ResourceCreator\Functions\IsTypescript;
use Bakgul\ResourceCreator\Tasks\RemoveLines;
use Illuminate\Support\Arr;

class Vue
{
    public function vendor(): string
    {
        return 'vue';
    }

    public function stub(string $variation = ''): string
    {
        return implode('.', array_filter(['vue', $variation, 'stub']));
    }

    public function api(?array $attr = null)
    {
        $cmp = $attr ? Arry::get($attr['pipeline']['options'], 'compositionAPI') : $attr
            ?? Settings::resources('vue.options.compositionAPI');

        return $cmp ? 'composition' : 'options';
    }

    public function view(array $attr): string
    {
        return $attr['variation'] == 'page' && Settings::apps("{$attr['app_key']}.router") == 'vue-router'
            ? Text::inject("  <router-view />", PHP_EOL)
            : '';
    }

    public function options(array $attr): array
    {
        return [
            'setup' => $this->isComposition($attr) ? ' setup' : '',
            'lang' => IsTypescript::_($attr) ? ' lang="ts"' : '',
        ];
    }

    public function isComposition(array $attr): bool
    {
        return Arr::get($attr, 'pipeline.options.compositionAPI')
            ?? Settings::resources('vue.options.compositionAPI');
    }

    public function removeOptionsAPI(array $attr): void
    {
        RemoveLines::byStr($attr, '{{{{', '}}}}', $this->api($attr) == 'composition');
    }
}
