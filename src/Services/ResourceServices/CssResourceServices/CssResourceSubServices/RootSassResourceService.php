<?php

namespace Bakgul\ResourceCreator\Services\ResourceServices\CssResourceServices\CssResourceSubServices;

use Bakgul\FileContent\Functions\CreateFile;
use Bakgul\Kernel\Helpers\Arry;
use Bakgul\Kernel\Helpers\Folder;
use Bakgul\Kernel\Helpers\Path;
use Bakgul\Kernel\Helpers\Settings;
use Bakgul\Kernel\Helpers\Text;
use Bakgul\ResourceCreator\Services\RequestServices\CssRequestServices\CssRequestSubServices\RootSassCssResourceService;
use Bakgul\ResourceCreator\Tasks\SetRelativePath;

class RootSassResourceService
{
    public function create(array $request): void
    {
        $request = (new RootSassCssResourceService)->handle($request);
        
        CreateFile::_($request);

        $this->useSass($request);
    }

    private function useSass($request)
    {
        if (Settings::standalone('package')) return;

        $usables = ['properties', '_index'];

        $uses = array_filter(
            $this->getFiles(),
            fn ($x) => Text::containsSome($x, $usables)
        );

        $lines = [];

        foreach (array_keys(Settings::structures('resources.sass')) as $folder) {
            $lines = array_merge($lines, array_map(
                fn ($x) => '@use ' . $this->getPointer($request['attr'], $x) . ';',
                Arry::sort(array_filter($uses, fn ($x) => str_contains($x, $folder)))
            ));
        }

        $this->write($request['attr'], $lines);
    }

    private function getFiles()
    {
        return Folder::files(Path::glue(
            [base_path(), 'resources', 'app', Settings::folders('css')]
        ));
    }

    private function getPointer($attr, $to)
    {
        $file = explode('.', Text::getTail($to))[0];

        return Text::wrap(implode('/', array_filter([
            SetRelativePath::_(Path::glue([$attr['path'], $attr['file']]), $to),
            $file == '_index' ? '' : $file     
        ])), 'dq');
    }

    private static function write($attr, $lines)
    {
        file_put_contents(
            Path::glue([$attr['path'], $attr['file']]),
            implode(PHP_EOL, $lines)
        );
    }
}