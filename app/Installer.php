<?php

declare(strict_types=1);

namespace App;

use Composer\Script\Event;
use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

// TODO : Exemple de fichiers composer ou on appel dans un certain ordre des commandes pour préparer l'application :
// ordre des commandes : https://getcomposer.org/doc/articles/scripts.md#command-events
//https://github.com/top-think/think/blob/6.0/composer.json
//https://github.com/spiral/app/blob/master/composer.json
//https://github.com/ventoviro/windwalker-starter/blob/master/composer.json
//https://github.com/yiisoft/demo/blob/master/composer.json
//https://github.com/symfony/demo/blob/main/composer.json
//https://github.com/laravel/laravel/blob/8.x/composer.json

//https://github.com/ventoviro/windwalker-core/blob/master/src/Core/Composer/StarterInstaller.php#L72
//https://github.com/ventoviro/windwalker-starter/blob/master/composer.json#L31

//https://github.com/cakephp/app/blob/master/src/Console/Installer.php
//https://github.com/craftcms/cms/blob/develop/bootstrap/bootstrap.php#L50
//https://github.com/prefeiturasp/minuta-participativa/blob/731ed5ebd3f3cbdb323ff14c3777fd221e68f64c/scripts/Bedrock/Installer.php#L40
//https://github.com/pixelfed/pixelfed/blob/f5260902293b35c830c865f5bc88162ae6e60f57/app/Console/Commands/Installer.php

//https://github.com/laravel/framework/blob/8.x/src/Illuminate/Foundation/ComposerScripts.php

final class Installer
{
    public static function prepareFolders(Event $event = null): void
    {
        self::chmodRecursive('runtime', 0777);
        self::chmodRecursive('public/assets', 0777);
    }

    private static function chmodRecursive(string $path, int $mode): void
    {
        chmod($path, $mode);
        $flags = FilesystemIterator::SKIP_DOTS | FilesystemIterator::CURRENT_AS_PATHNAME;

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($path, $flags),
            RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $item) {
            chmod($item, $mode);
        }
    }


    public static function thanksReminder(Event $event = null): void
    {
        $io = $event->getIO();

        $io->writeError('');
        $io->writeError('Try running the command <comment>bin/chiron thanks</> to spread some love!</>');
        $io->writeError('');
    }
}
