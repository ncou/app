<?php

declare(strict_types=1);

return [
        'basePath'        => '/',
        'headers'           => [],
        'middlewares'       => [App\Middleware\XClacksOverheadMiddleware::class],
];
