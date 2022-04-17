<?php

namespace Bakgul\ResourceCreator\Tests\Isolated\FunctionTests;

use Bakgul\Kernel\Tests\TestCase;
use Bakgul\ResourceCreator\Functions\SetFileName;

class SetFileNameTest extends TestCase
{
    /** @test */
    public function set_file_name()
    {
        $this->assertEquals('customer_services.js', SetFileName::_([
            'attr' => [
                'app_type' => 'not_nuxt',
                'variation' => 'page',
                'convention' => 'snake',
                'extension' => 'js'
            ],
            'map' => [
                'name' => 'CustomerServices'
            ]
        ]));
    }

    /** @test */
    public function set_file_name_force_kebab()
    {
        $this->assertEquals('customer-services.js', SetFileName::_([
            'attr' => [
                'app_type' => 'nuxt',
                'variation' => 'page',
                'convention' => 'pascal',
                'extension' => 'js'
            ],
            'map' => [
                'name' => 'CustomerServices'
            ]
        ]));
    }
}
