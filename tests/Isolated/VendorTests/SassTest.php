<?php

namespace Bakgul\ResourceCreator\Tests\Isolated\VendorTests;

use Bakgul\Kernel\Tasks\CompleteFolders;
use Bakgul\Kernel\Tasks\ConvertCase;
use Bakgul\Kernel\Tests\Tasks\SetupTest;
use Bakgul\Kernel\Tests\TestCase;
use Bakgul\ResourceCreator\Vendors\Sass;

class SassTest extends TestCase
{
    private $c;
    private $name = 'store-users';
    private $ext = 'scss';

    public function __construct()
    {
        $this->c = new Sass;

        parent::__construct();
    }

    /** @test */
    public function sass_vendor()
    {
        $this->assertEquals('sass', $this->c->vendor());
    }

    /** @test */
    public function sass_stub()
    {
        $this->assertEquals("css.stub", $this->c->stub());
    }

    /** @test */
    public function sass_class()
    {
        foreach (['pascal', 'kebab', 'snake', 'camel'] as $case) {
            $this->assertEquals(
                ".{$this->name} {}",
                $this->c->class(ConvertCase::{$case}($this->name))
            );
        }
    }

    /** @test */
    public function sass_forward()
    {
        $this->assertEquals('@forward "./' . $this->name . '";', $this->c->forward($this->name));
    }

    /** @test */
    public function sass_use()
    {
        (new SetupTest)(isBlank: true);

        $this->assertEquals('', $this->c->use([]));

        [$path, $_] = $this->prepareFiles();

        $this->assertEquals('', $this->c->use([
            'extension' => 'x'
        ]));

        $this->assertEquals(
            '@use "../../../../../../resources/styles/abstractions/variables.scss" as *;' . "\n\n",
            $this->c->use([
                'extension' => $this->ext,
                'path' => $path
            ])
        );
    }

    /** @test */
    public function sass_target()
    {
        foreach ([[], ['one', 'two']] as $subs) {
            $this->assertEquals(
                $this->user() . DIRECTORY_SEPARATOR . "_index.{$this->ext}",
                $this->c->target([
                    'attr' => ['path' => $this->user($subs), 'extension' => $this->ext],
                    'map' => ['subs' => implode(DIRECTORY_SEPARATOR, $subs)]
                ]),
                implode('.', $subs)
            );
        }
    }

    private function prepareFiles()
    {
        $user = $this->user();
        $using = $this->using();

        array_map(fn ($x) => CompleteFolders::_($x, false), [$user, $using]);

        file_put_contents($using . DIRECTORY_SEPARATOR . "variables.{$this->ext}", '');

        return [$user, $using];
    }

    private function user($subs = [])
    {
        return base_path(implode(DIRECTORY_SEPARATOR, ['packages', 'testings', 'testing', 'resources', 'admin', 'sass', ...$subs]));
    }

    private function using()
    {
        return base_path(implode(DIRECTORY_SEPARATOR, ['resources', 'styles', 'abstractions']));
    }
}
