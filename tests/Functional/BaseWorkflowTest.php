<?php

declare(strict_types=1);

namespace Worker\Tests\Functional;

use Temporal\Client\GRPC\ServiceClient;
use Temporal\Client\WorkflowClient;
use Temporal\DataConverter\Type;
use Temporal\Testing\ActivityMocker;
use Worker\Contracts\BaseWorkflowInterface;
use Worker\Tests\TestCase;

class BaseWorkflowTest extends TestCase
{
    private WorkflowClient $workflowClient;
    private ActivityMocker $activityMocks;

    protected function setUp(): void
    {
        $this->workflowClient = new WorkflowClient(ServiceClient::create('localhost:7233'));
//        $this->activityMocks = new ActivityMocker();

        parent::setUp();
    }

    public function testBaseWorkflow(): void
    {
        $workflow = $this->workflowClient->newWorkflowStub(BaseWorkflowInterface::class);

        $run = $this->workflowClient->start($workflow);

        self::assertSame(
            'array',
            $run->getResult(Type::TYPE_STRING)
        );
    }
}