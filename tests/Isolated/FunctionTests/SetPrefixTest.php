<?php

namespace Bakgul\ResourceCreator\Functions;

use Bakgul\Kernel\Helpers\Settings;
use Bakgul\Kernel\Tests\TestCase;

class SetPrefixTest extends TestCase
{
    /** @test */
    public function set_prefix()
    {
        Settings::set('resource_options.use_prefix', true);

        Settings::set('prefixes.component', 'comp');
        $this->assertEquals('comp', SetPrefix::_('component'));

        Settings::set('prefixes.page', '');
        $this->assertEquals('', SetPrefix::_('page'));

        Settings::set('resource_options.use_prefix', false);
        $this->assertEquals('', SetPrefix::_('component'));
    }
}
