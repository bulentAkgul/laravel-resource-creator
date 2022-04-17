<?php

namespace Bakgul\ResourceCreator\Tests\Isolated\VendorTests;

use Bakgul\Kernel\Helpers\Path;
use Bakgul\Kernel\Tests\TestCase;
use Bakgul\ResourceCreator\Vendors\Vuex;

class VuexTest extends TestCase
{
    private $c;

    public function __construct()
    {
        $this->c = new Vuex;

        parent::__construct();
    }

    /** @test */
    public function vuex_vendor()
    {
        $this->assertEquals('vuex', $this->c->vendor());
    }

    /** @test */
    public function vuex_stub()
    {
        $this->assertEquals('js.vue.vuex.stub', $this->c->stub('not_section'));
        $this->assertEquals('js.vue.section.stub', $this->c->stub('section'));
    }

    /** @test */
    public function vuex_map_functions()
    {
        $this->assertEquals(['computeds' => ['State', 'Getters'], 'methods' => ['Actions']], $this->c->mapFunctions());
        $this->assertEquals(['State', 'Getters'], $this->c->mapFunctions('computeds'));
        $this->assertEquals(['Actions'], $this->c->mapFunctions('methods'));
    }

    /** @test */
    public function vuex_map_function()
    {
        $this->assertEquals('{}', $this->c->mapFunction());
    }
    /** @test */
    public function vuex_import()
    {
        $this->assertEquals('', $this->c->import());
    }

    /** @test */
    public function vuex_file()
    {
        $this->assertEquals('IndexUsers', $this->c->file(['name' => 'IndexUsers']));
    }
}
