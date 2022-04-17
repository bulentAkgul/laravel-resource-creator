<?php

namespace Bakgul\ResourceCreator\Tests\Isolated\FunctionTests;

use Bakgul\Kernel\Tests\TestCase;
use Bakgul\ResourceCreator\Functions\ConvertValue;

class ConvertValueTest extends TestCase
{
    /** @test */
    public function convert_value_with_array()
    {
        $this->assertEquals('SomethingLikeThis', ConvertValue::_([
            'a_key' => 'something-like-this',
            'convention' => 'pascal'
        ], 'a_key'));

        $this->assertEquals('something_like_this', ConvertValue::_([
            'a_key' => 'SomethingLikeThis',
            'convention' => 'snake'
        ], 'a_key'));

        $this->assertEquals('someCars', ConvertValue::_([
            'a_key' => 'some_car',
            'convention' => 'camel'
        ], 'a_key', false));
    }

    /** @test */
    public function convert_value_with_string()
    {
        $this->assertEquals(
            'SomethingLikeThis',
            ConvertValue::_('something-like-this', 'pascal')
        );

        $this->assertEquals(
            'vip-user',
            ConvertValue::_('vipUsers', 'kebab', true)
        );

        $this->assertEquals(
            'VipUsers',
            ConvertValue::_('vipUsers')
        );
    }
}
