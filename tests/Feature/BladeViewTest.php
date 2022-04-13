<?php

namespace Bakgul\ResourceCreator\Tests\Feature;

use Bakgul\Kernel\Tests\Tasks\SetupTest;
use Bakgul\Kernel\Tests\TestCase;

class BladeViewTest extends TestCase
{
    /** @test */
    public function deneme_testi()
    {
        $this->testPackage = (new SetupTest)();

        $this->artisan("create:resource posts:index view:page {$this->testPackage['name']} web");

        $this->assertTrue(true);
    }
}