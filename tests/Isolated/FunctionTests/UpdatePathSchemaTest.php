<?php

namespace Bakgul\ResourceCreator\Functions;

use Bakgul\Kernel\Tests\TestCase;

class UpdatePathSchemaTest extends TestCase
{
    /** @test */
    public function update_path_schema()
    {
        $this->assertEquals(
            base_path() . '{{ container }}{{ wrapper }}',
            UpdatePathSchema::_([
                'wrapper' => 'something',
                'path' => base_path() . '{{ container }}{{ folder }}'
            ], 'path')
        );
    }
}
