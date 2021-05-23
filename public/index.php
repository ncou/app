<?php

declare(strict_types=1);

$currentDir = PHP_SAPI === 'cli' ? getcwd() : realpath(getcwd().'/../');

require $currentDir . '/bootstrap/requirements.php';
require $currentDir . '/vendor/autoload.php';

Chiron\Debug\Debugger::enable();

$paths = require $currentDir . '/bootstrap/paths.php';
$app = new Chiron\Application($paths);

exit($app->start());
