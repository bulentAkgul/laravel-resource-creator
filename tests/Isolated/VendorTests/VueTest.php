<?php

namespace Bakgul\ResourceCreator\Tests\Isolated\VendorTests;

use Bakgul\Kernel\Helpers\Path;
use Bakgul\Kernel\Tests\TestCase;
use Bakgul\ResourceCreator\Vendors\Vue;

class VueTest extends TestCase
{
    private $c;

    public function __construct()
    {
        $this->c = new Vue;

        parent::__construct();
    }

    /** @test */
    public function vue_vendor()
    {
        $this->assertEquals('vue', $this->c->vendor());
    }

    /** @test */
    public function vue_stub()
    {
        $this->assertEquals('vue.stub', $this->c->stub());
        $this->assertEquals('vue.stub', $this->c->stub(''));
        $this->assertEquals('vue.section.stub', $this->c->stub('section'));
    }

    /** @test */
    public function vue_api()
    {
        foreach ([true, false] as $cmp) {
            config()->set('packagify.resources.vue.options.compositionAPI', $cmp);
            $this->assertEquals($cmp ? 'composition' : 'options', $this->c->api());
            $this->assertEquals($cmp ? 'composition' : 'options', $this->c->api([
                'pipeline' => ['options' => ['compositionAPI' => $cmp]]
            ]));
        }
    }

    /** @test */
    public function vue_view()
    {
        $this->assertEquals(PHP_EOL . '  <router-view />' . PHP_EOL, $this->c->view('page'));
        $this->assertEquals('', $this->c->view('not_page'));
    }

    /** @test */
    public function vue_options()
    {
        $this->assertEquals(
            ['setup' => ' setup', 'lang' => ' lang="ts"'],
            $this->c->options([
                'type' => 'vue',
                'extension' => 'vue',
                'pipeline' => [
                    'options' => ['compositionAPI' => true, 'ts' => true]
                ]
            ])
        );

        $this->assertEquals(
            ['setup' => ' setup', 'lang' => ''],
            $this->c->options([
                'type' => 'vue',
                'extension' => 'vue',
                'pipeline' => [
                    'options' => ['compositionAPI' => true, 'ts' => false]
                ]
            ])
        );

        config()->set('packagify.resources.vue.options.compositionAPI', false);
        config()->set('packagify.resources.vue.options.ts', true);
        $this->assertEquals(
            ['setup' => '', 'lang' => ' lang="ts"'],
            $this->c->options([
                'type' => 'vue',
                'extension' => 'vue',
            ])
        );

        config()->set('packagify.resources.vue.options.compositionAPI', false);
        config()->set('packagify.resources.vue.options.ts', false);
        $this->assertEquals(
            ['setup' => '', 'lang' => ''],
            $this->c->options([
                'type' => 'vue',
                'extension' => 'vue',
            ])
        );
    }

    /** @test */
    public function vue_remove_options_api()
    {
        $file = base_path('sample.vue');
        $stub = file_get_contents(Path::glue([__DIR__, '..', '..', '..', '..', 'stubs', 'resource', $this->c->stub()]));

        foreach ([true, false] as $cmp) {
            file_put_contents($file, $stub);

            $this->c->removeOptionsAPI([
                'path' => base_path(),
                'file' => 'sample.vue',
                'pipeline' => ['options' => ['compositionAPI' => $cmp]]
            ]);

            $content = file_get_contents($file);

            $this->assertTrue(!str_contains($content, '{{{{'));
            $this->assertTrue(!str_contains($content, '}}}}'));
            $this->assertNotEquals(str_contains($content, 'export default {'), $cmp);
            $this->assertNotEquals(str_contains($content, 'methods: {{{ methods }}},'), $cmp);
        }

        unlink($file);
    }
}
