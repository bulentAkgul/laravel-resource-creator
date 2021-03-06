<?php

namespace Bakgul\ResourceCreator\Vendors;

use Bakgul\Kernel\Functions\UpdateSchema;

class VueRouter
{
    public function vendor(): string
    {
        return 'vue-router';
    }

    public function stub(): string
    {
        return 'js.vue.route.stub';
    }

    public function file(array $request): string
    {
        return "{$request['map']['name']}.{$request['attr']['extension']}";
    }

    public function schema(array $attr): string
    {
        return UpdateSchema::_($attr['path_schema'], 'variation', '');
    }
}
