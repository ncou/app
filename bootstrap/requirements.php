<?php

/*
 * You can empty out this file, if you are certain that you match all requirements.
 */

/*
 * You can remove this if you are confident that your PHP version is sufficient.
 */
if (version_compare(PHP_VERSION, '7.2.0') < 0) {
    die('Your PHP version must be equal or higher than 7.2.0 to use Chiron.');
}

/*
 * You can remove this if you are confident you have intl installed.
 */
if (! extension_loaded('intl')) {
    die('You must enable the intl extension to use Chiron.');
}

/*
 * You can remove this if you are confident you have proper version of intl.
 */
/*
if (version_compare(INTL_ICU_VERSION, '50.1', '<')) {
    die('ICU >= 50.1 is needed to use Chiron. Please update the `libicu` package of your system.' . PHP_EOL);
}*/

/*
 * You can remove this if you are confident you have mbstring installed.
 */
if (! extension_loaded('mbstring')) {
    die('You must enable the mbstring extension to use Chiron.');
}

/*
 * You can remove this if you are confident user are using Composer.
 */
if (! is_dir(dirname(__DIR__). '/vendor/composer/')) {
    die('You need to set up the project dependencies using Composer.');
}
