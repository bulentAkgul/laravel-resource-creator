<?php

namespace Bakgul\ResourceCreator\Tests\Feature;

use Bakgul\Kernel\Tests\Concerns\HasTestMethods;
use Bakgul\Kernel\Tests\Tasks\SetupTest;
use Bakgul\Kernel\Tests\TestCase;

class DenemeTest extends TestCase
{

    /** @test */
    public function packagified_laravel_resource()
    {
        $this->testPackage = (new SetupTest)();

        $this->artisan('create:resource button view:module testing');

        $this->assertTrue(true);
    }

    /** @test */
    public function standalone_laravel_resource()
    {
        $this->testPackage = (new SetupTest)([false, true]);

        $this->artisan('create:resource posts:index view:page admin');

        $this->assertTrue(true);
    }

    /** @test */
    public function standalone_package_resource()
    {
        $this->testPackage = (new SetupTest)([true, false]);

        $this->artisan('create:resource posts:all view:page admin');

        $this->assertTrue(true);
    }
}
