<?php

declare(strict_types=1);

namespace Worker\Contracts;

use Generator;
use Temporal\DataConverter\Type;
use Temporal\Workflow\ReturnType;
use Temporal\Workflow\WorkflowInterface;
use Temporal\Workflow\WorkflowMethod;

#[WorkflowInterface]
interface BaseWorkflowInterface
{
    #[WorkflowMethod]
    #[ReturnType(Type::TYPE_STRING)]
    public function create(Config $config): Generator;
}
