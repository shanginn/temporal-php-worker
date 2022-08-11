<?php

declare(strict_types=1);

namespace Worker\Services;

use Temporal\Activity\ActivityInterface;
use Temporal\Activity\ActivityMethod;
use Temporal\DataConverter\Type;
use Temporal\Workflow\ReturnType;

#[ActivityInterface(prefix: 'Greetings.')]
class GreetingsService
{
    #[ActivityMethod(name: 'sayHello')]
    public function sayHello(string $prefix, string $name): array
    {
        return [$prefix => "{$name}!"];
    }
}
