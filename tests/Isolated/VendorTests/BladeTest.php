<?php

namespace Bakgul\ResourceCreator\Tests\Isolated\VendorTests;

use Bakgul\Kernel\Helpers\Settings;
use Bakgul\Kernel\Tests\TestCase;
use Bakgul\ResourceCreator\Vendors\Blade;

class BladeTest extends TestCase
{
    private $c;

    public function __construct()
    {
        $this->c = new Blade;

        parent::__construct();
    }

    /** @test */
    public function blade_vendor()
    {
        $this->assertEquals('blade', $this->c->vendor());
    }

    /** @test */
    public function blade_stub()
    {
        foreach (['component', 'page', 'module'] as $variation) {
            $this->assertEquals("blade.{$variation}.stub", $this->c->stub(['attr' => ['variation' => $variation]]));
        }
    }

    /** @test */
    public function blade_package()
    {
        $this->assertEquals('', $this->c->package(''));
        $this->assertEquals('package:', $this->c->package('package'));
    }

    /** @test */
    public function blade_extend()
    {
        $subs = ['one', 'two', 'three'];

        $this->assertEquals('', $this->c->extend(['variation' => 'not_section']));
        
        $this->assertEquals(implode('.', [...$subs, 'users']), $this->c->extend([
            'variation' => 'section',
            'path' => base_path(Settings::folders('view') . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $subs)),
            'convention' => 'kebab',
            'parent' => ['name' => 'users']
        ]));
    }
}
