<?php

declare(strict_types=1);

namespace App\Bootloader;

use Chiron\Bootload\AbstractBootloader;
use Chiron\Http\MiddlewareQueue;
use App\Middleware\XClacksOverheadMiddleware;

class AddMiddlewareBootloader extends AbstractBootloader
{
    public function boot(MiddlewareQueue $middlewares)
    {
        $middlewares->addMiddleware(XClacksOverheadMiddleware::class);
    }
}
