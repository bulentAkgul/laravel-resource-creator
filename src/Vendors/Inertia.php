<?php

namespace Bakgul\ResourceCreator\Vendors;

use Bakgul\Kernel\Functions\CreateFile;
use Bakgul\Kernel\Helpers\Path;
use Bakgul\Kernel\Helpers\Settings;
use Bakgul\Kernel\Helpers\Text;
use Bakgul\ResourceCreator\Tasks\SetRelativePath;

class Inertia
{
    public function vuePageAdaptor(array $request)
    {
        if (Settings::apps("{$request['attr']['app_key']}.router") != 'inertia') return $request;

        $request['map']['layout'] = $this->layout();
        $request['map']['imports'] = $this->imports($request);
        $request['map']['script'] = $this->script($request['attr']);

        return $request;
    }

    public function layout(): string
    {
        return !Settings::resources('vue.options.compositionAPI')
            ? PHP_EOL . "  layout: Layout,"
            : '';
    }

    public function imports(array $request): string
    {
        return $request['map']['imports'] . PHP_EOL . $this->importLayout($request['attr']);
    }

    public function script(array $attr): string
    {
        if (!Settings::resources('vue.options.compositionAPI')) return '';

        return implode(PHP_EOL, [
            '',
            '<script>',
            $this->importLayout($attr),
            "export default {",
            "  layout: Layout",
            "}",
            "</script>"
        ]);
    }

    private function importLayout(array $attr): string
    {
        return "import Layout from {$this->relativePathToLayout($attr)};";
    }

    private function relativePathToLayout(array $attr): string
    {
        return Text::inject(
            SetRelativePath::_($attr['path'], $this->layoutPath($attr)) . 'Layout.vue',
            '"'
        );
    }

    public function layoutPath(array $attr): string
    {
        $folder = Text::append(Settings::folders('view'));

        return explode($folder, $attr['path'])[0] . $folder;
    }

    public function makeLayout(array $request): void
    {
        $request['attr']['path'] = $this->layoutPath($request['attr']);
        $request['attr']['file'] = 'Layout.vue';

        if (file_exists(Path::glue([
            $request['attr']['path'], $request['attr']['file']
        ]))) return;
        
        $request['map']['name_pascal'] = 'Layout';
        $request['map']['imports'] = '';
        $request['map']['computeds'] = '';
        $request['map']['methods'] = '';
        $request['map']['layout'] = '';
        $request['map']['script'] = '';
        $request['map']['view'] = implode(PHP_EOL, ['', '  <div>', '    <slot />', '  </div>', '']);

        CreateFile::_($request);

        (new Vue)->removeOptionsAPI($request['attr']);
    }
}
