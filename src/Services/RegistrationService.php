<?php

namespace Bakgul\ResourceCreator\Services;

use Bakgul\Kernel\Helpers\Arry;
use Bakgul\FileContent\Helpers\Content;
use Bakgul\FileContent\Tasks\ExtendCodeBlock;
use Bakgul\FileContent\Tasks\ExtendCodeLine;
use Bakgul\FileContent\Tasks\GetCodeBlock;
use Bakgul\FileContent\Tasks\GetCodeLine;
use Bakgul\FileContent\Tasks\WriteToFile;
use Bakgul\ResourceCreator\ResourceCreator;
use Bakgul\ResourceCreator\Tasks\Register;

class RegistrationService extends ResourceCreator
{
    // protected array $path;
    protected array $request;
    // protected array $fileContent;

    protected function setRequest(array $request): void
    {
        $this->request = $request;
    }

    protected function register(array $lineSpecs, array $blockSpecs, string $key, ?string $only = null)
    {
        Register::_($this->request, $lineSpecs, $blockSpecs, $key, $only);
        // $this->getTargetFileContent();

        // if ($this->isNotRegisterable(Arry::get($lineSpecs, 'isEmpty'))) return;

        // if ($only != 'block') $this->insertCodeLines($this->setLineSpecs($lineSpecs));

        // if ($only != 'line') $this->insertCodeBlock($this->setBlockSpecs($blockSpecs), key: $key);

        // $this->write();
    }

    // protected function getTargetFileContent()
    // {
    //     $this->fileContent = Content::read($this->request['attr']['target_file'], purify: false);
    // }

    // protected function isNotRegisterable(?bool $isEmpty)
    // {
    //     return $this->isContentNotReady($isEmpty)
    //         || Arry::contains($this->request['map']['imports'], $this->fileContent);
    // }

    // protected function setLineSpecs(array $specs)
    // {
    //     return array_merge([
    //         'isStrict' => false,
    //         'part' => '',
    //         'repeat' => 0,
    //         'isSortable' => true,
    //         'isEmpty' => false
    //     ], $specs);
    // }

    // protected function setBlockSpecs(array $specs)
    // {
    //     return array_merge([
    //         'end' => ['}', 0],
    //         'isStrict' => true,
    //         'repeat' => 1,
    //         'isSortable' => false
    //     ], $specs);
    // }

    // protected function isContentNotReady(?bool $isEmpty)
    // {
    //     return !$isEmpty && empty($this->fileContent);
    // }

    // protected function insertCodeLines(array $specs): void
    // {
    //     [$start, $end, $imports] = GetCodeLine::_($this->fileContent, $specs);

    //     $this->purifyContent($start, $end);

    //     $this->regenerateContent($start, $this->makeCodeLines($imports));
    // }

    // protected function insertCodeBlock(array $specs, string|array $add = '', string $key = ''): void
    // {
    //     [$start, $indentation, $end, $block] = $this->getCodeLines($specs);

    //     $this->purifyContent($start, $end);

    //     $this->regenerateContent($start, $this->makeCodeBlock($block, $add, $key, $indentation, $specs));
    // }

    // protected function getCodeLines(array $specs): array
    // {
    //     return GetCodeBlock::_($this->fileContent, $specs);
    // }

    // protected function purifyContent(int $start, int $end): void
    // {
    //     $this->fileContent = Content::purify($this->fileContent, $start, $end);
    // }

    // private function makeCodeLines($imports)
    // {
    //     return ExtendCodeLine::_($imports, $this->request['map']['imports']);
    // }

    // private function makeCodeBlock($block, $add, $key, $indentation, $specs)
    // {
    //     return ExtendCodeBlock::_(
    //         $block,
    //         $add ?: $this->request['map'][$key],
    //         ['base' => $indentation, 'repeat' => $specs['repeat']],
    //         $specs
    //     );
    // }

    // protected function regenerateContent(int $start, array $insert)
    // {
    //     $this->fileContent = Content::regenerate($this->fileContent, $start, $insert);
    // }

    // protected function write()
    // {
    //     WriteToFile::handle($this->fileContent, $this->request['attr']['target_file']);
    // }
}
