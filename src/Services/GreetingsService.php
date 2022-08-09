<?php

declare(strict_types=1);

namespace Worker\Services;

use Temporal\Activity\ActivityInterface;
use Temporal\Activity\ActivityMethod;
use Worker\Contracts\Config;

#[ActivityInterface(prefix: 'Greetings.')]
class GreetingsService
{
    #[ActivityMethod(name: 'sayHello')]
    public function sayHello(Config $prefix, string $name): string
    {
        return "Hello, {$prefix->prefix} {$prefix->second} {$prefix->third} {$name}!";
    }
}
