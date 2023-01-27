<?php

declare(strict_types=1);

namespace Worker\Tests\Functional;

use Temporal\Client\GRPC\ServiceClient;
use Temporal\Client\WorkflowClient;
use Temporal\Testing\ActivityMocker;
use Worker\Contracts\LoaderWorkflowInterface;
use Worker\Tests\TestCase;

class LoaderWorkflowTest extends TestCase
{
    private WorkflowClient $workflowClient;
    private ActivityMocker $activityMocks;

    protected function setUp(): void
    {
        $this->workflowClient = new WorkflowClient(ServiceClient::create('localhost:7233'));
        $this->activityMocks  = new ActivityMocker();

        parent::setUp();
    }

    public function testLoaderWorkflow(): void
    {
        $batches = [10, 10, 10, 10, 10, 10, 10, 10, 10, 9];
        $offset  = 0;

        foreach ($batches as $fakeItemsCount) {
            $data = [];

            for ($i = 0; $i < $fakeItemsCount; ++$i) {
                $data[] = [
                    'id' => $id = $offset + $i + 1,
                ];

                $this->activityMocks->expectCompletion(
                    activityMethodName: 'ApiService.sendRequest',
                    value: 'Mocked response for ' . (string) $id
                );
            }

            $this->activityMocks->expectCompletion(
                activityMethodName: 'SchedulerService.load',
                value: [
                    'data'  => $data,
                    'count' => count($data),
                ]
            );

            ++$offset;
        }

        $workflow = $this->workflowClient->newWorkflowStub(LoaderWorkflowInterface::class);

        $run = $this->workflowClient->start($workflow);

        self::assertSame(
            99,
            $run->getResult('int')
        );
    }
}