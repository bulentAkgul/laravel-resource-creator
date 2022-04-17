<?php

namespace Bakgul\ResourceCreator\Tests\Isolated\VendorTests;

use Bakgul\FileContent\Tasks\CompleteFolders;
use Bakgul\Kernel\Tests\Tasks\SetupTest;
use Bakgul\Kernel\Tests\TestCase;
use Bakgul\ResourceCreator\Vendors\Pinia;

class PiniaTest extends TestCase
{
    private $c;
    private $map1 = [
        'label' => 'Index',
        'prefix' => '',
        'task' => '',
        'wrapper' => 'Posts'
    ];
    private $map2 = [
        'label' => '',
        'prefix' => 'Custom',
        'task' => 'BuyAll',
        'wrapper' => 'Stuff'
    ];

    public function __construct()
    {
        $this->c = new Pinia;

        parent::__construct();
    }

    /** @test */
    public function pinia_vendor()
    {
        $this->assertEquals('pinia', $this->c->vendor());
    }

    /** @test */
    public function pinia_stub()
    {
        $this->assertEquals('js.vue.pinia.stub', $this->c->stub());
    }

    /** @test */
    public function pinia_schema()
    {
        $this->assertEquals('use{{ prefix }}{{ label }}{{ task }}{{ wrapper }}', $this->c->schema(false));
        $this->assertEquals('use{{ prefix }}{{ label }}{{ task }}{{ wrapper }}Store', $this->c->schema(true));
    }

    /** @test */
    public function pinia_file()
    {
        $this->assertEquals('useIndexPosts', $this->c->file($this->map1));

        $this->assertEquals('useCustomBuyAllStuff', $this->c->file($this->map2));
    }

    /** @test */
    public function pinia_name()
    {
        $this->assertEquals('useIndexPostsStore', $this->c->name($this->map1));

        $this->assertEquals('useCustomBuyAllStuffStore', $this->c->name($this->map2));
    }

    /** @test */
    public function pinia_map_functions()
    {
        $this->assertEquals(['computeds' => ['State'], 'methods' => ['Actions']], $this->c->mapFunctions());
        $this->assertEquals(['State'], $this->c->mapFunctions('computeds'));
        $this->assertEquals(['Actions'], $this->c->mapFunctions('methods'));
    }

    /** @test */
    public function pinia_map_function()
    {
        $this->assertEquals('useIndexPostsStore, []', $this->c->mapFunction($this->map1));
        $this->assertEquals('useCustomBuyAllStuffStore, []', $this->c->mapFunction($this->map2));
    }

    /** @test */
    public function pinia_import()
    {
        [$request, $_, $_] = $this->prepareFiles();

        $this->assertEquals(
            'import { useIndexPostsStore } from "../../../scripts/Stores/Pages/Posts/useIndexPosts"',
            $this->c->import($request)
        );
    }

    /** @test */
    public function pinia_paths()
    {
        [$request, $base, $tail] = $this->prepareFiles();

        $this->assertEquals(
            ["{$base}/views/{$tail}", "{$base}/scripts/Stores/{$tail}/useIndexPosts.js"],
            $this->c->paths($request)
        );
    }

    private function prepareFiles()
    {
        $this->testPackage = (new SetupTest)();

        $base = base_path("packages/testings/testing/resources/clients/admin");
        $tail = "Pages/Posts";
        $js = implode("/", [$base, "scripts/Stores", $tail]);

        CompleteFolders::_($js, false);

        file_put_contents("{$js}/useIndexPosts.js", '');

        return [
            [
                'attr' => ['path' => implode("/", [$base, "views", $tail])],
                'map' => $this->map1
            ],
            $base,
            $tail
        ];
    }
}
