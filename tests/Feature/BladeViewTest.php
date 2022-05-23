<?php

namespace Bakgul\ResourceCreator\Tests\Feature;

use Bakgul\Kernel\Helpers\Settings;
use Bakgul\Kernel\Tests\Tasks\SetupTest;
use Bakgul\Kernel\Tests\TestCase;

class BladeViewTest extends TestCase
{
    /** @test */
    public function blade_component()
    {
        $this->testPackage = (new SetupTest)();

        $this->artisan("create:resource posts view:component {$this->testPackage['name']} web");

        $this->assertTrue(true);
    }

    /** @test */
    public function blade_module()
    {
        $this->testPackage = (new SetupTest)();

        $this->artisan("create:resource posts view:module {$this->testPackage['name']} web");

        $this->assertTrue(true);
    }

    /** @test */
    public function blade_section()
    {
        $this->testPackage = (new SetupTest)();

        $this->artisan("create:resource posts view:section {$this->testPackage['name']} web");

        $this->assertTrue(true);
    }

    /** @test */
    public function blade_section_taskless_tasks_as_not_sections()
    {
        $this->testPackage = (new SetupTest)();

        $this->artisan("create:resource index-post view:section {$this->testPackage['name']} web -t");

        $this->assertTrue(true);
    }

    /** @test */
    public function blade_page()
    {
        $this->testPackage = (new SetupTest)();

        $this->artisan("create:resource posts:index view:page {$this->testPackage['name']} web");

        $this->assertTrue(true);
    }

    /** @test */
    public function blade_page_tasks_as_not_sections()
    {
        $this->testPackage = (new SetupTest)();

        Settings::set('main.tasks_as_sections', false);

        $this->artisan("create:resource posts view:page {$this->testPackage['name']} web");

        $this->assertTrue(true);
    }

    /** @test */
    public function blade_page_taskless()
    {
        $this->testPackage = (new SetupTest)();

        Settings::set('main.tasks_as_sections', false);

        $this->artisan("create:resource posts view:page {$this->testPackage['name']} web -t");

        $this->assertTrue(true);
    }

    /** @test */
    public function blade_will_have_controller_when_variation_is_page()
    {
        $this->testPackage = (new SetupTest)();

        // Settings::set('repository.standalone_laravel', true);
        Settings::set('main.each_page_has_controller', true);
        Settings::set('main.tasks_as_sections', false);

        $this->artisan("create:resource posts view:page {$this->testPackage['name']} web");

        $this->assertTrue(true);
    }
}