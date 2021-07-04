<?php

declare(strict_types=1);

namespace App\Bootloader;

use App\Controller\HomeController;
use Chiron\Core\Container\Bootloader\AbstractBootloader;
use Chiron\Routing\Map;

// TODO : exemple avec un fichier pour des routes sous forme de callback 'populateRoutes()'
//https://github.com/flarum/core/blob/0c95774333a4c15a1990faf477fabe15e298d6c0/src/Forum/ForumServiceProvider.php#L188
//https://github.com/flarum/core/blob/0c95774333a4c15a1990faf477fabe15e298d6c0/src/Forum/routes.php

class LoadRoutesBootloader extends AbstractBootloader
{
    public function boot(Map $map)
    {
        $map->map('/{action}')->method('GET')->to([HomeController::class, 'index'])->name('home'); // TODO : utiliser ->get() au lien me ->map() et virer la commande ->method('GET')
    }
}
