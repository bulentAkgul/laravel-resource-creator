<?php

namespace Bakgul\ResourceCreator\Commands;

use Bakgul\Kernel\Concerns\HasPreparation;
use Bakgul\Kernel\Concerns\HasRequest;
use Bakgul\Kernel\Concerns\Sharable;
use Bakgul\Evaluator\Concerns\ShouldBeEvaluated;
use Bakgul\Evaluator\Services\ResourceCommandEvaluationService;
use Bakgul\FileHistory\Concerns\HasHistory;
use Bakgul\Kernel\Helpers\Settings;
use Bakgul\Kernel\Tasks\MakeFileList;
use Bakgul\ResourceCreator\Services\ResourceService;
use Bakgul\ResourceCreator\Tasks\ModifyFileList;
use Illuminate\Console\Command;

class CreateResourceCommand extends Command
{
    use HasHistory, HasPreparation, HasRequest, Sharable, ShouldBeEvaluated;

    protected $signature = '
        create:resource
        {name : subs/name:task}
        {type : type:variation:role}
        {package?}
        {app?}
        {--p|parent=}
        {--c|class}
        {--t|taskless}
        {--f|force}
    ';

    protected $description = 'This command is to create the view, style, and javascript files.';

    protected $arguments = [
        'name' => [
            'Required',
            'subs' => [
                "Optional",
                "You can specify subfolders like 'sub1/sub2/sub3' when you need",
                "a deeper file structure than the file types path_schema provides.",
            ],
            'name' => [
                "Required",
                "A filename without any suffix."
            ],
            'task' => [
                "Optional",
                "You may set one or more tasks with a dot-separated fashion like",
                "'users:index' or 'users:index.store.update'. If you pass a task",
                "that isn't listed in the tasks list of the given type or its",
                "pairs and the global list (tasks on 'config/packagify.php'),",
                "it'll be ignored. A separate file will be generated for each",
                "task of the underlying file type and its pairs when the task",
                "isn't specified."
            ],
        ],
        'type' => [
            'Required',
            'type' => [
                'Required',
                "It should be one of 'view, css, js.' It will be determined which file",
                "type will be generated based on the app type. For example, if you create",
                "files for the admin app, and the admin app's type is 'vue', then the view",
                "files will be Vue, and js files will be 'store' and 'route' files.",
                "The settings of those types are in the 'resources' array on 'packagify.php'"
            ],
            'variation' => [
                'Required',
                "It should be one of the variations of the specified file type."
            ],
            'role' => [
                "Optional",
                "It should be one of the items in the roles array. When you create",
                "a Livewire file, make sure you set this to 'livewire.' If it isn't",
                "specified, it will be the default one which is no-role."
            ]
        ],
        'package' => [
            "Optional",
            "It won't be used when working on a Standalone Laravel or Standalone Package.",
            "If you don't set a valid name, the file will be generated in the App namespace."
        ],
        'app' => [
            "Optional",
            "To create files for a specific app, you need to set the app name.",
            "The settings are in the 'apps' array on 'packagify.php'."
        ],
    ];

    protected $options = [
        'parent' => [
            "When the variation is 'section', it's required to pass a parent name,",
            "which is the page that will hold the creating section."
        ],
        'class' => [
            "The value of 'blade.options.class' in the resources array will be altered",
            "when the command has '-c' or '--class'. When that setting is 'true,' the",
            "Blade files will have a class pair and be used like '<x-comp>  </x-comp>.'",
            "Otherwise, they will be like parent-child files and used through 'extends,",
            "section, yield.'"
        ],
        'taskless' => [
            "The sections will be generated as a separate file for each task unless",
            "the comment has tasks. But sometimes, you may want to create a single file",
            "without any task. In such cases, you need to append '-t' or '--taskless'",
            "to the command. This will cancel the default behavior of the task explosion."
        ],
        'force' => [
            "Normally, a file will not be regenerated if it exists. If this option is",
            "passed, a new file will be created anyway."
        ],
    ];

    protected $examples = [];
    
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

        if (Settings::evaluator('evaluate_commands')) {
            $this->evaluate();
            if ($this->stop()) return $this->terminate();
        }

        $queue = ModifyFileList::_(MakeFileList::_($this->request));

        $this->logFile();

        $this->createFiles($queue);
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
