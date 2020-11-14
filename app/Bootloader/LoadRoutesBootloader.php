<?php

declare(strict_types=1);

namespace App\Bootloader;

use App\Controller\HomeController;
use Chiron\Core\Container\Bootloader\AbstractBootloader;
use Chiron\Routing\RouteCollection;

class LoadRoutesBootloader extends AbstractBootloader
{
    public function boot(RouteCollection $routes)
    {
        $routes->map('/{action}')->method('GET')->to([HomeController::class, 'index'])->name('home');
    }
}
