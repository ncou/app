<?php

/*
 * You can empty out this file, if you are certain that you match all requirements.
 */

/*
 * You can remove this if you are confident that your PHP version is sufficient.
 */
if (version_compare(PHP_VERSION, '8.0.0') < 0) {
    die('Your PHP version must be equal or higher than 8.0.0 to use Chiron.');
}

/*
 * You can remove this if you are confident user are using Composer.
 */
if (! is_dir(dirname(__DIR__). '/vendor/composer/')) {
    die('You need to set up the project dependencies using Composer.');
}
