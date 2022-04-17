<?php

namespace Bakgul\ResourceCreator\Functions;

use Bakgul\Kernel\Tests\TestCase;

class UpdateParentTest extends TestCase
{
    /** @test */
    public function update_parent()
    {
        $this->assertEquals(
            ['name' => 'updated'],
            UpdateParent::_([
                'wrapper' => 'updated',
                'parent' => ['name' => 'initial']
            ])
        );

        $this->assertEquals(
            ['name' => 'initial'],
            UpdateParent::_([
                'parent' => ['name' => 'initial']
            ])
        );
    }
}
