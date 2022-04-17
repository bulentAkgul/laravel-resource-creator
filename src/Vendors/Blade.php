<?php

namespace Bakgul\ResourceCreator\Vendors;

use Bakgul\Kernel\Helpers\Settings;
use Bakgul\Kernel\Helpers\Text;
use Bakgul\ResourceCreator\Functions\ConvertValue;

class Blade
{
    public function vendor()
    {
        return 'blade';
    }

    public function stub(array $request): string
    {
        return "blade.{$request['attr']['variation']}.stub";
    }

    public function package(string $package)
    {
        return Text::prepend($package ?: '', ':');
    }

    public function extend(array $attr)
    {
        if ($attr['variation'] != 'section') return '';

        return $attr['variation'] == 'section'
            ? $this->path($attr['path']) . '.' . ConvertValue::_($attr['parent'], 'name')
            : '';
    }

    private function path($path)
    {
        return str_replace(DIRECTORY_SEPARATOR, '.', explode(
            Settings::folders('view') . DIRECTORY_SEPARATOR,
            $path
        )[1]);
    }
}