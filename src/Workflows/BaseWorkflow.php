<?php

declare(strict_types=1);

namespace Worker\Workflows;

use Carbon\CarbonInterval;
use Generator;
use Temporal\Activity\ActivityOptions;
use Temporal\Workflow;
use Temporal\Workflow\WorkflowInterface;
use Worker\Contracts\BaseWorkflowInterface;
use Worker\Contracts\Config;
use Worker\Services\GreetingsService;

#[WorkflowInterface]
class BaseWorkflow implements BaseWorkflowInterface
{
    /**
     * @var GreetingsService
     */
    private $greetingsService;

    public function __construct()
    {
        $this->greetingsService = Workflow::newActivityStub(
            GreetingsService::class,
            ActivityOptions::new()
                ->withStartToCloseTimeout(CarbonInterval::minute())
        );
    }

    public function create(Config $config = new Config): Generator
    {
        return yield $this->greetingsService->sayHello(
            prefix: $config->prefix,
            name: 'World',
        );
    }
}
