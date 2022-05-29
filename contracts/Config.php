<?php

declare(strict_types=1);

namespace Worker\Contracts;

class Config
{
    public function __construct(
        public readonly string $prefix = 'Mr. '
    ) {
    }
}
