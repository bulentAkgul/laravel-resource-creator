<?php

namespace Bakgul\ResourceCreator\Tests\Feature;

use Bakgul\Kernel\Tests\Services\TestDataService;
use Bakgul\Kernel\Tests\Tasks\SetupTest;
use Bakgul\Kernel\Tests\TestCase;

class DenemeTest extends TestCase
{
    /** @test */
    public function packagified_laravel_resource()
    {
        $this->testPackage = (new SetupTest)();

        $this->artisan('create:resource posts view:page testing admin');
        
        $this->assertTrue(true);
    }

    /** @test */
    public function standalone_laravel_resource()
    {
        $this->testPackage = (new SetupTest)(TestDataService::standalone('sl'));

        $this->artisan('create:resource posts view:page web');

        $this->assertTrue(true);
    }

    /** @test */
    public function standalone_package_resource()
    {
        $this->testPackage = (new SetupTest)(TestDataService::standalone('sp'));

        $this->artisan('create:resource posts view:page admin');

        $this->assertTrue(true);
    }
}
