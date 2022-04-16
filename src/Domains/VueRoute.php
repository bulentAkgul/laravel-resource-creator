<?php

namespace Bakgul\ResourceCreator\Domains;

use Bakgul\Kernel\Helpers\Settings;
use Bakgul\ResourceCreator\Functions\RequestFunctions\UpdateSchema;

class VueRoute
{
    public static function _(array $request)
    {
        if (self::isNotRoutable($request['attr'])) return '';
        return '';
    }

    private static function isNotRoutable(array $attr): bool
    {
        return !in_array($attr['variation'], Settings::resourceOptions('levels.high'))
            || in_array(Settings::apps($attr['router']), Settings::prohibitives('route'));
    }

    public function stub(): string
    {
        return 'js.vue.route.stub';
    }

    public function file(array $request): string
    {
        return "{$request['map']['name']}.js";
    }

    public function route(array $request): string
    {
        return '';
    }

    public function schema(array $attr): string
    {
        return UpdateSchema::_($attr['path_schema'], 'variation', '');
    }
}


/*


function setPath(array $request): string
{
    if ($this->isNotRoutable($request['attr'])) return '';

    return Settings::resourceOptions('tasks_as_sections')
        ? $this->subPath($request)
        : $this->fullPath($request);
}



function fullPath(array $request)
{
    return Path::glue(array_filter([
        Str::slug(ConvertCase::kebab($request['map']['wrapper'])),
        ...$this->setSubs($request['attr']['subs']),
        Str::slug($this->replace($request['map'], str_replace('{{ wrapper }}', '', $request['attr']['name_schema']), true, '-')),
    ]));
}

function setSubs(array $subs): array
{
    return array_map(fn ($x) => Str::slug($x), Path::make($subs, 'kebab'));
}

function subPath(array $request): string
{
    $subs = Path::glue($this->setSubs($request['attr']['subs']), '/');
    $path = $this->setTaskRoute($request['attr']['task']);

    return Str::slug(
        $request['attr']['variation'] == 'page'
            ? ConvertCase::kebab($request['map']['name'])
            : $this->getSlug($request)
    );
}

function setTaskRoute(string $task): string
{
    return $task ? Settings::resourceOptions("route_schemas.{$task}") : '';
}

function getSlug(array $request): string
{
    $parts = ConvertCase::kebab($request['map']['name'], returnArray: true);
    $first = array_shift($parts);

    return implode('-', array_filter([
        ...$parts, $first == $request['attr']['parent']['name'] ? '' : $first
    ]));
}

*/