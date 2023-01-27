<?php

declare(strict_types=1);

namespace Worker\Services;

use Temporal\Activity\ActivityInterface;
use Temporal\Activity\ActivityMethod;

#[ActivityInterface(prefix: 'ApiService.')]
class ApiService
{
    #[ActivityMethod(name: 'sendRequest')]
    public function sendRequest(string $id): string
    {
        // TODO: send actual api request
        return sprintf('Sent, %s!', $id);
    }
}
