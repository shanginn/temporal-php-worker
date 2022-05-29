<?php

declare(strict_types=1);

namespace Worker\Services;

use Temporal\Activity\ActivityInterface;
use Temporal\Activity\ActivityMethod;

#[ActivityInterface(prefix: 'Greetings.')]
class GreetingsService
{
    #[ActivityMethod(name: 'sayHello')]
    public function sayHello(string $prefix, string $name): string
    {
        return "Hello, {$prefix} {$name}!";
    }
}
