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
        return implode(PHP_EOL, [
            $request['map']['imports'],
            $this->importLayout($request['attr'], true)
        ]);
    }

    public function script(array $attr): string
    {
        if (!Settings::resources('vue.options.compositionAPI')) return '';

        return implode(PHP_EOL, [
            '',
            '<script>',
            $this->setLayout($attr),
            "</script>"
        ]);
    }

    private function setLayout(array $attr): string
    {
        return Settings::resources("{$attr['app_type']}.options.code_splitting")
            ? implode(PHP_EOL, [
                "export default { ",
                "  Layout: import('{$this->importLayout($attr, true)}')",
                "};"
            ])
            : $this->importLayout($attr, false);
    }

    private function importLayout(array $attr, $splittable): string
    {
        return $splittable
            ? $this->relativePathToLayout($attr)
            : implode(PHP_EOL, [
                "import Layout from {$this->relativePathToLayout($attr)}",
                "export default { Layout }"
            ]);
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
