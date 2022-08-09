<?php

declare(strict_types=1);

namespace Worker\Tests\Functional;

use Temporal\Client\GRPC\ServiceClient;
use Temporal\Client\WorkflowClient;
use Temporal\Testing\ActivityMocker;
use Worker\Contracts\BaseWorkflowInterface;
use Worker\Contracts\Config;
use Worker\Tests\TestCase;

class BaseWorkflowTest extends TestCase
{
    private WorkflowClient $workflowClient;
    private ActivityMocker $activityMocks;

    protected function setUp(): void
    {
        $this->workflowClient = new WorkflowClient(ServiceClient::create('localhost:7233'));
        $this->activityMocks = new ActivityMocker();

        parent::setUp();
    }

    public function testBaseWorkflow(): void
    {
        $workflow = $this->workflowClient->newWorkflowStub(BaseWorkflowInterface::class);

        $run = $this->workflowClient->start(
            $workflow,
            new Config('from', 'readonly', 'properties')
        );

        self::assertSame(
            'Hello, from readonly properties World!',
            $run->getResult('string')
        );
    }
}