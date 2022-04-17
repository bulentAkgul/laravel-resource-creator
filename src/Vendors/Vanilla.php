<?php

namespace Bakgul\ResourceCreator\Vendors;

use Bakgul\Kernel\Tasks\ConvertCase;
use Bakgul\ResourceCreator\Functions\IsTypescript;

class Vanilla
{
    public function extension(array $attr): string
    {
        return IsTypescript::_($attr) ? 'ts' : 'js';
    }

    public function stub(array $attr): string
    {
        return implode('.', array_filter(
            ['js', $attr['pipeline']['options']['oop'] ? 'class' : '', 'stub']
        ));
    }

    public function extend(array $attr): string
    {
        return $attr['variation'] == 'section'
            ? ' extends ' . ConvertCase::pascal($attr['parent']['name'])
            : '';
    }

    public function export(string $variation)
    {
        return $variation == 'page' ? 'export default ' : '';
    }

    public function import(array $attr)
    {
        return $attr['variation'] == 'section'
            ? implode('', [
                'import ',
                ConvertCase::pascal($attr['parent']['name']),
                ' from "./',
                ConvertCase::_($attr['parent']['name'], $attr['convention']),
                '";',
                "\n\n"
            ]) : '';
    }
}
