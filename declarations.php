<?php

declare(strict_types=1);

return [
    'orders' => [
        'workflows' => [
            \Worker\Workflows\LoaderWorkflow::class,
        ],
        'activities' => [
            \Worker\Services\ApiService::class,
            \Worker\Services\SchedulerService::class
        ],
    ],
];
