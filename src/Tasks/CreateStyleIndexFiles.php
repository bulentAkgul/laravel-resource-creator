<?php

namespace Bakgul\ResourceCreator\Tasks;

use Bakgul\FileHistory\Services\LogServices\ForUndoingLogService;
use Bakgul\Kernel\Helpers\Arry;
use Bakgul\Kernel\Helpers\Text;

class CreateStyleIndexFiles
{
    const DIVIDER = 'container';

    public static function sass(array $request)
    {
        self::completeFiles($request);
    }

    private static function completeFiles(array $request)
    {
        $file = Text::getTail($request['attr']['target_file']);

        [$path, $folders] = self::serialize($request);
        ray([$path, $folders]);
        foreach ($folders as $i => $folder) {
            $path .= "/{$folder}";

            self::makeFile("{$path}/{$file}", Arry::get($folders, $i + 1));
        }
    }

    private static function serialize(array $request): array
    {
        $parts = array_map(fn ($x) => trim($x, '/'), self::preparePath($request));

        return [
            "/{$parts[0]}",
            self::setTail($request['map'][self::DIVIDER], $parts[1])
        ];
    }

    private static function preparePath(array $request): array
    {
        return explode(
            $request['map'][self::DIVIDER],
            str_replace($request['map']['subs'], '', $request['attr']['path'])
        );
    }

    private static function setTail(string $container, string $tail): array
    {
        return explode('/', Text::prepend($container) . $tail);
    }

    private static function makeFile(string $file, ?string $next)
    {
        if (file_exists($file)) return;

        file_put_contents($file, self::makeForwardLine($next));

        ForUndoingLogService::set($file, false, true);
    }

    private static function makeForwardLine(?string $next)
    {
        return $next ? '@forward "./' . $next . '";' : '';
    }
}