<?php

declare(strict_types=1);

namespace Worker\Workflows;

use Carbon\CarbonInterval;
use Generator;
use Temporal\Activity\ActivityOptions;
use Temporal\Workflow;
use Temporal\Workflow\WorkflowInterface;
use Worker\Contracts\Config;
use Worker\Contracts\LoaderWorkflowInterface;
use Worker\Services\ApiService;
use Worker\Services\SchedulerService;

#[WorkflowInterface]
class LoaderWorkflow implements LoaderWorkflowInterface
{
    /**
     * @var SchedulerService
     */
    private $schedulerService;

    /**
     * @var ApiService
     */
    private $apiService;

    public function __construct()
    {
        $this->schedulerService = Workflow::newActivityStub(
            SchedulerService::class,
            ActivityOptions::new()
                ->withStartToCloseTimeout(CarbonInterval::minute())
        );

        $this->apiService = Workflow::newActivityStub(
            ApiService::class,
            ActivityOptions::new()
                ->withStartToCloseTimeout(CarbonInterval::minute())
        );
    }

    public function create(Config $config = new Config()): Generator
    {
        $offset = 0;
        $limit  = $config->batchSize;

        do {
            [
                'data'  => $data,
                'count' => $count
            ] = yield $this->schedulerService->load($offset, $limit);

            $offset += $limit;

            foreach ($data as $item) {
                yield $this->apiService->sendRequest((string) $item['id']);
            }
        } while ($count > 0);
    }
}
