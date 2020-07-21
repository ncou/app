<?php

declare(strict_types=1);

$currentDir = PHP_SAPI === 'cli' ? getcwd() : realpath(getcwd().'/../');

require_once $currentDir . '/bootstrap/requirements.php';
require_once $currentDir . '/vendor/autoload.php';

$paths = require_once $currentDir . '/bootstrap/paths.php';
$app = Chiron\Application::init($paths);

exit($app->run());
