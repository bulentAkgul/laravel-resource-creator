<?php

namespace Bakgul\ResourceCreator\Vendors;

use Bakgul\Kernel\Functions\UpdateSchema;
use Bakgul\Kernel\Helpers\Folder;
use Bakgul\Kernel\Helpers\Settings;
use Bakgul\Kernel\Helpers\Text;
use Bakgul\ResourceCreator\Functions\IsFilesPath;
use Bakgul\ResourceCreator\Tasks\SetRelativePath;

class Pinia
{
    public function vendor()
    {
        return 'pinia';
    }

    public function stub()
    {
        return 'js.vue.pinia.stub';
    }

    public function schema(bool $withSuffix): string
    {
        $schema = UpdateSchema::_(Settings::resources('pinia.name_schema'), 'schema', Settings::files('js.name_schema'));

        if (!$withSuffix) {
            $schema = Text::changeTail($schema, '', '}}');
        }

        return UpdateSchema::_($schema, 'name', 'label');
    }

    public function file($map)
    {
        return Text::replaceByMap($map, $this->schema(false));
    }

    public function name($map)
    {
        return Text::replaceByMap($map, $this->schema(true));
    }

    public function mapFunctions(?string $key = '')
    {
        return Settings::resources('pinia.maps' . Text::append($key, '.'));
    }

    public function mapFunction($map)
    {
        return $this->name($map) . ", []";
    }

    public function import(array $request)
    {
        return "import { "
            . $this->name($request['map'])
            . ' } from "'
            . SetRelativePath::_(...$this->paths($request))
            . Text::append($this->file($request['map']))
            . '"';
    }

    public function paths(array $request): array
    {
        $file = $this->file($request['map']);

        $paths = Folder::files(explode(
            Settings::folders('apps'),
            $request['attr']['path']
        )[0]);

        $to = '';

        foreach ($paths as $path) {
            if (IsFilesPath::_($file, 'js', $path)) {
                $to = $path;
                break;
            }
        }

        return [$request['attr']['path'], $to];
    }
}
