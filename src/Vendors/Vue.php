<?php

namespace Bakgul\ResourceCreator\Vendors;

use Bakgul\Kernel\Helpers\Arry;
use Bakgul\Kernel\Helpers\Path;
use Bakgul\Kernel\Helpers\Text;
use Illuminate\Support\Str;

class Vue
{
    public function removeOptionsAPI(array $attr): void
    {
        $path = Path::glue([$attr['path'], $attr['file']]);

        $content = file_get_contents($path);

        file_put_contents($path, str_replace(array_filter([
            $this->block($content, $attr), '{{{{', '}}}}'
        ]), '', $content));
    }

    private function block($content, $attr)
    {
        return Arry::get($attr['pipeline']['options'], 'compositionAPI')
            ? Str::between($content, '{{{{', '}}}}')
            : '';
    }

    public function stub(string $variation): string
    {
        return "vue.{$variation}.stub";
    }

    public function options(array $options): array
    {
        return [
            'setup' => Arry::get($options, 'compositionAPI') ? ' setup' : '',
            'lang' => Arry::get($options, 'ts') && Arry::get($options, 'compositionAPI') ? ' lang="ts"' : '',
        ];
    }

    public function view(string $variation) : string
    {
        return $variation == 'page'
            ? Text::inject("  <router-view />", PHP_EOL)
            : '';
    }
}
