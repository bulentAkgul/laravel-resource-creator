<?php

namespace Bakgul\ResourceCreator\Commands;

use Bakgul\Kernel\Concerns\HasPreparation;
use Bakgul\Kernel\Concerns\HasRequest;
use Bakgul\Kernel\Concerns\Sharable;
use Bakgul\Evaluator\Concerns\ShouldBeEvaluated;
use Bakgul\Kernel\Tasks\MakeFileList;
use Bakgul\ResourceCreator\Services\ResourceService;
use Bakgul\ResourceCreator\Tasks\CreateBackendFiles;
use Illuminate\Console\Command;

class CreateResourceCommand extends Command
{
    use HasPreparation, HasRequest, Sharable, ShouldBeEvaluated;

    protected $signature = '
        create:resource
        {name : subs/name:task}
        {type : type:variation:extra}
        {package?}
        {app?}
        {--p|parent= : name:type:variation:grandparent}
        {--c|class}
        {--t|taskless}
        {--f|force}
    ';

    protected $description = 'extra is (type == "view" && app == null ? file type : js role), class is wheter blade component has related class';
    private $service;

    public function __construct()
    {
        $this->setEvaluator(ResourceCommandEvaluationService::class);
        $this->service = new ResourceService;

        parent::__construct();
    }

    public function handle()
    {
        $this->prepareRequest();

        // $this->evaluate();

        // if ($this->stop()) return $this->terminate();

        $queue = MakeFileList::_($this->request);

        $this->createFiles($queue);

        CreateBackendFiles::_($this->request, $queue);
    }

    private function createFiles(array $queue)
    {
        array_map(fn ($x) => $this->create($x, $queue), $queue);
    }

    private function create(array $file, array $queue)
    {
        $this->service->create($this->makeFileRequest($file, $queue));
    }
}
