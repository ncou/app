<?php

$rootPath = dirname(__DIR__, 1);

return [
    '@root'         => $rootPath,
    '@app'          => '@root/app',
    '@config'       => '@root/config',
    '@public'       => '@root/public',
    '@resources'    => '@root/resources',
    '@runtime'      => '@root/runtime',
    '@vendor'       => '@root/vendor',
    '@views'        => '@resources/views',
    '@cache'        => '@runtime/cache',
    '@logs'         => '@runtime/logs',
];
