<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';


//date_default_timezone_set('UTC');
//setlocale(LC_ALL, 'C.UTF-8');


session_start();

setlocale(LC_TIME, ['fr','fr_FR','fr_FR@euro','fr_FR.utf8','fr-FR','fra']);

//$this->charset = $charset ?: (ini_get('default_charset') ?: 'UTF-8');

$charset = "UTF-8";

// Encoding
ini_set('default_charset', $charset);
if (extension_loaded('mbstring')) {
    mb_internal_encoding($charset);
}

// TODO : à virer ???? normalement la classe RegisterErrorHandler met déjà le error_reporting level à E_ALL !!!!
error_reporting(E_ALL);


$app = Chiron\Application::init();

/*
$app = Chiron\Application::init([
    'root' => __DIR__,
]);
*/

$app->start();
