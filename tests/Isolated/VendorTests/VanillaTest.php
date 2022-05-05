<?php

namespace Bakgul\ResourceCreator\Tests\Isolated\VendorTests;

use Bakgul\Kernel\Helpers\Settings;
use Bakgul\Kernel\Tasks\ConvertCase;
use Bakgul\Kernel\Tests\TestCase;
use Bakgul\ResourceCreator\Vendors\Vanilla;

class VanillaTest extends TestCase
{
    private $c;
    private $name = 'store-users';

    public function __construct()
    {
        $this->c = new Vanilla;

        parent::__construct();
    }

    /** @test */
    public function vanilla_extension()
    {
        $this->assertEquals('ts', $this->c->extension([
            'pipeline' => ['options' => ['ts' => true]]
        ]));

        Settings::set('resources.vue.options.ts', false);
        $this->assertEquals('ts', $this->c->extension([
            'pipeline' => ['options' => ['ts' => true]]
        ]));

        Settings::set('resources.js.extension', 'ts');
        $this->assertEquals('ts', $this->c->extension([
            'type' => 'js'
        ]));

        Settings::set('resources.js.extension', 'js');
        $this->assertEquals('js', $this->c->extension([
            'type' => 'js'
        ]));

        Settings::set('resources.js.options.ts', true);
        $this->assertEquals('ts', $this->c->extension([
            'type' => 'js'
        ]));
    }

    /** @test */
    public function vanilla_stub()
    {
        foreach ([true, false] as $oop) {
            $this->assertEquals(
                implode('.', array_filter(['js', $oop ? 'class' : '', 'stub'])),
                $this->c->stub(
                    ['pipeline' => ['options' => ['oop' => $oop]]]
                )
            );
        }
    }

    /** @test */
    public function vanilla_extend()
    {
        $this->assertEquals('', $this->c->extend(['variation' => 'not_section']));

        $this->assertEquals(
            ' extends ' . ConvertCase::pascal($this->name),
            $this->c->extend([
                'variation' => 'section',
                'convention' => 'pascal',
                'parent' => ['name' => $this->name]
            ])
        );
    }

    /** @test */
    public function vanilla_export()
    {
        $this->assertEquals('', $this->c->export('not_page'));
        $this->assertEquals('export default ', $this->c->export('page'));
    }

    /** @test */
    public function vanilla_import()
    {
        $this->assertEquals('', $this->c->import(['variation' => 'not_section']));

        $this->assertEquals(
            'import StoreUsers from "./' . ConvertCase::snake($this->name) . '";' . "\n\n",
            $this->c->import([
                'variation' => 'section',
                'convention' => 'snake',
                'parent' => ['name' => $this->name]
            ])
        );
    }
}
