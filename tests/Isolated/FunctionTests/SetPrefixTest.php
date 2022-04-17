<?php

namespace Bakgul\ResourceCreator\Functions;

use Bakgul\Kernel\Tests\TestCase;

class SetPrefixTest extends TestCase
{
    /** @test */
    public function set_prefix()
    {
        config()->set('packagify.resource_options.use_prefix', true);

        config()->set('packagify.prefixes.component', 'comp');
        $this->assertEquals('comp', SetPrefix::_('component'));

        config()->set('packagify.prefixes.page', '');
        $this->assertEquals('', SetPrefix::_('page'));

        config()->set('packagify.resource_options.use_prefix', false);
        $this->assertEquals('', SetPrefix::_('component'));
    }
}