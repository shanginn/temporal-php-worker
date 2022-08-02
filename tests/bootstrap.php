<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Temporal\Testing\Environment;

$environment = Environment::create();
$environment->start('./rr serve -c .rr.test.yaml -w tests');
register_shutdown_function(fn () => $environment->stop());
