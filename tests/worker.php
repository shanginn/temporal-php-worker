<?php

declare(strict_types=1);

use Temporal\Testing\WorkerFactory;

ini_set('display_errors', 'stderr');
include '../vendor/autoload.php';

$factory = WorkerFactory::create();
$worker = $factory->newWorker();

$declarationPath = realpath(__DIR__ . '/../declarations.php');

if ($declarationPath === false || !is_file($declarationPath)) {
    $declarations = [];
} else {
    $declarations = include $declarationPath;
}

foreach ($declarations as $package => $declaration) {
    $worker->registerWorkflowTypes(...$declaration['workflows']);

    foreach ($declaration['activities'] ?? [] as $activity) {
        $worker->registerActivityImplementations(new $activity);
    }
}

$factory->run();
