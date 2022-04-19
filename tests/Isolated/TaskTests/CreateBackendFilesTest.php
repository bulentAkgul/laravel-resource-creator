<?php

namespace Bakgul\ResourceCreator\Tasks;

use Bakgul\Kernel\Helpers\Settings;
use Bakgul\Kernel\Tests\TestCase;

class CreateBackendFilesTest extends TestCase
{
    /** @test */
    public function command_will_not_be_created()
    {
        Settings::set('resource_ptions.each_page_has_controller', true);

        $this->assertTrue(CreateBackendFiles::isNotCreatable([
            'type' => 'css'
        ], []));

        $this->assertTrue(CreateBackendFiles::isNotCreatable([
            'type' => 'vue',
            'extra' => '',
            'class' => ''
        ], []));

        

        Settings::set('resource_ptions.each_page_has_controller', false);
    }
}
