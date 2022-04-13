<?php

namespace Bakgul\ResourceCreator\Tasks;

use Bakgul\Kernel\Helpers\Folder;
use Bakgul\Kernel\Helpers\Settings;
use Bakgul\Kernel\Helpers\Text;
use Bakgul\ResourceCreator\Helpers\Pinia;

class SetPiniaImport
{
    public static function _(array $request)
    {
        return "import { "
            . Pinia::name($request['map'])
            . ' } from "'
            . SetRelativePath::_(...self::paths($request))
            . Text::append(Pinia::file($request['map']))
            . '"';
    }
    
    public static function paths(array $request): array
    {
        $file = Pinia::file($request['map']);

        $paths = Folder::files(explode(
            Settings::folders('apps'), 
            $request['attr']['path']
            )[0]);
            
        $to = '';
        
        foreach ($paths as $path) {
            if (!str_contains($path, DIRECTORY_SEPARATOR . "{$file}.js")) continue;
            
            $to = $path;
            break;
        }
        
        return [$request['attr']['path'], $to];
    }
}