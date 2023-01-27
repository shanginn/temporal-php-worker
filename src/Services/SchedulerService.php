<?php

declare(strict_types=1);

namespace Worker\Services;

use Temporal\Activity\ActivityInterface;
use Temporal\Activity\ActivityMethod;
use Worker\Repositories\SchedulerRepository;

#[ActivityInterface(prefix: 'SchedulerService.')]
class SchedulerService
{
    private SchedulerRepository $repository;

    public function __construct()
    {
        $this->repository = new SchedulerRepository();
    }

    /**
     * @param int $offset
     * @param int $limit
     *
     * @return array{data: array<array{id: int}>, count: int}
     */
    #[ActivityMethod(name: 'load')]
    public function load(int $offset, int $limit): array
    {
        // Call to the actual repository
        return $this->repository->load($offset, $limit);
    }
}
