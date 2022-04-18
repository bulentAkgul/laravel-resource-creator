<?php

namespace Bakgul\ResourceCreator\Tasks;

use Bakgul\Kernel\Helpers\Path;

class GetClass
{
    public static function resource(array $attr, string $namespace): string
    {
        $category = $attr['category'] == $attr['type'] ? '' : $attr['category'];

        return Path::glue([
            $namespace,
            ucfirst($attr['category']) . 'ResourceServices',
            ucfirst($attr['type']) . ucfirst($category) . 'ResourceService'
        ], '\\');
    }

    public static function css(array $attr, string $namespace): string
    {
        return Path::glue([
            $namespace,
            "CssResourceServices",
            ucfirst($attr['type']) . 'CssResourceService'
        ], '\\');
    }

    public static function view(array $attr, string $namespace, ?string $variation = null): string
    {
        return Path::glue([
            '',
            $namespace,
            'ViewResourceSubServices',
            ucfirst($variation ?: $attr['variation']) . ucfirst($attr['type']) . 'ViewResourceService'
        ], '\\');
    }
}
