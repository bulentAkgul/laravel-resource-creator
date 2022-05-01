<?php

namespace Bakgul\ResourceCreator\Tests\Feature;

use Bakgul\Kernel\Tests\Services\TestDataService;
use Bakgul\Kernel\Tests\Tasks\SetupTest;
use Bakgul\Kernel\Tests\TestCase;

class SharedFolderTest extends TestCase
{
    /** @test */
    public function view_files_will_be_generated_in_the_shared_folder_when_command_has_extra_and_has_not_app()
    {
        $this->testPackage = (new SetupTest)(TestDataService::standalone('pl'));

        $this->artisan("create:resource posts view:component:blade {$this->testPackage['name']}");

        $this->assertTrue(true);
    }
}