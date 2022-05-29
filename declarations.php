<?php

declare(strict_types=1);

return [
    'orders' => [
        'workflows' => [
            \Worker\Workflows\BaseWorkflow::class,
        ],
        'activities' => [
            \Worker\Services\GreetingsService::class,
        ],
    ],
];
