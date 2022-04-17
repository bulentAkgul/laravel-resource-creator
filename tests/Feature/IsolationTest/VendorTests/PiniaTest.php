<?php

namespace Bakgul\ResourceCreator\Tests\Feature\IsolationTest\VendorTests;

use Bakgul\FileContent\Tasks\CompleteFolders;
use Bakgul\Kernel\Tests\Tasks\SetupTest;
use Bakgul\Kernel\Tests\TestCase;
use Bakgul\ResourceCreator\Vendors\Pinia;

class PiniaTest extends TestCase
{
    private $p;
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
        $this->p = new Pinia;

        parent::__construct();
    }

    /** @test */
    public function pinia_vendor()
    {
        $this->assertEquals('pinia', $this->p->vendor());
    }

    /** @test */
    public function pinia_stub()
    {
        $this->assertEquals('js.vue.pinia.stub', $this->p->stub());
    }

    /** @test */
    public function pinia_schema()
    {
        $this->assertEquals('use{{ prefix }}{{ label }}{{ task }}{{ wrapper }}', $this->p->schema(false));
        $this->assertEquals('use{{ prefix }}{{ label }}{{ task }}{{ wrapper }}Store', $this->p->schema(true));
    }

    /** @test */
    public function pinia_file()
    {
        $this->assertEquals('useIndexPosts', $this->p->file($this->map1));

        $this->assertEquals('useCustomBuyAllStuff', $this->p->file($this->map2));
    }

    /** @test */
    public function pinia_name()
    {
        $this->assertEquals('useIndexPostsStore', $this->p->name($this->map1));

        $this->assertEquals('useCustomBuyAllStuffStore', $this->p->name($this->map2));
    }

    /** @test */
    public function pinia_mapFunctions()
    {
        $this->assertEquals(['computeds' => ['State'], 'methods' => ['Actions']], $this->p->mapFunctions());
    }

    /** @test */
    public function pinia_mapFunction()
    {
        $this->assertEquals('useIndexPostsStore, []', $this->p->mapFunction($this->map1));
        $this->assertEquals('useCustomBuyAllStuffStore, []', $this->p->mapFunction($this->map2));
    }

    /** @test */
    public function pinia_import()
    {
        [$request, $_, $_] = $this->prepareFiles();

        $this->assertEquals(
            'import { useIndexPostsStore } from "../../../scripts/Stores/Pages/Posts/useIndexPosts"',
            $this->p->import($request)
        );
    }

    /** @test */
    public function pinia_paths()
    {
        [$request, $base, $tail] = $this->prepareFiles();

        $this->assertEquals(
            ["{$base}/views/{$tail}", "{$base}/scripts/Stores/{$tail}/useIndexPosts.js"],
            $this->p->paths($request)
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
