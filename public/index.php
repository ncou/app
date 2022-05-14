<?php

// The full path to the directory which holds "src", WITHOUT a trailing directory separator.
$rootPath = dirname(__DIR__);

require $rootPath . '/bootstrap/requirements.php';
require $rootPath . '/vendor/autoload.php';

Chiron\Debug\Debugger::enable();

$paths = require $rootPath . '/bootstrap/paths.php';
$app = new Chiron\Application($paths);

exit($app->start());
