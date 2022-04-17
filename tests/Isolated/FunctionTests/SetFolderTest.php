<?php

namespace Bakgul\ResourceCreator\Functions;

use Bakgul\Kernel\Tests\TestCase;

class SetFolderTest extends TestCase
{
    /** @test */
    public function set_folder_by_passing_folder()
    {
        $this->assertEquals('UserFolder', SetFolder::_([
            'folder' => 'user_folder', 'convention' => 'pascal'
        ]));
    }

    /** @test */
    public function set_folder_without_predefined_folder()
    {
        $this->assertEquals('users', SetFolder::_([
            'name' => 'users', 'variation' => 'page'
        ]));

        $this->assertEquals('people', SetFolder::_([
            'name' => 'users',
            'variation' => 'section',
            'parent' => ['name' => 'people']
        ]));

        $this->assertEquals('users', SetFolder::_([
            'name' => 'users',
            'variation' => 'section',
            'parent' => ['name' => '']
        ]));

        $this->assertEquals('', SetFolder::_([
            'name' => 'users',
            'variation' => 'module',
        ]));
    }
}
