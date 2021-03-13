<?php

return [
        'base_path'   => '/',
        'headers'     => ['X-Powered-By' => 'Charlie Sheen’s Tiger Blood'],// TODO : attention ca marche pas !!!!
        'middlewares' => [App\Middleware\XClacksOverheadMiddleware::class],
];
