<?php

namespace Bakgul\ResourceCreator\Functions;

use Bakgul\Kernel\Helpers\Settings;
use Bakgul\Kernel\Tests\TestCase;

class IsSharableTest extends TestCase
{
    /** @test */
    public function is_shareble()
    {
        Settings::set('resource_options.levels.low', ['xxxx']);
        Settings::set('resource_options.share_low_levels_between_apps', true);

        $this->assertTrue(IsSharable::_('xxxx'));
        $this->assertNotTrue(IsSharable::_('yyyy'));

        Settings::set('resource_options.share_low_levels_between_apps', false);

        $this->assertNotTrue(IsSharable::_('xxxx'));
    }
}
