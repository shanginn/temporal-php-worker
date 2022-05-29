<?php

declare(strict_types=1);

use Temporal\WorkerFactory;

ini_set('display_errors', 'stderr');
include "vendor/autoload.php";

$factory = WorkerFactory::create();
$worker = $factory->newWorker();

$declarationPath = realpath(__DIR__ . '/declarations.php');

if (!is_file($declarationPath)) {
    $declarations = [];
} else {
    $declarations = include $declarationPath;
}

foreach ($declarations as $package => $declaration) {
    foreach ($declaration['workflows'] ?? [] as $workflow) {
        $worker->registerWorkflowTypes($workflow);
    }

    foreach ($declaration['activities'] ?? [] as $activity) {
        $worker->registerActivity($activity);
    }
}

$factory->run();
