<?php

declare(strict_types=1);

namespace App;

use Composer\Script\Event;
use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Exception;

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

/**
 * Provides installation hooks for when this application is installed through
 * composer. Customize this class to suit your needs.
 */
final class Installer
{
    /**
     * An array of directories to be made writable
     */
    private const WRITABLE_DIRS = [
        'runtime',
        'runtime/cache',
        'runtime/logs',
    ];

    /**
     * Does some routine installation tasks so people don't have to.
     *
     * @param \Composer\Script\Event $event The composer event object.
     * @throws \Exception Exception raised by validator.
     *
     * @return void
     */
    public static function initProject(Event $event): void
    {
        $io = $event->getIO();

        $rootDir = dirname(__DIR__, 1);

        static::createDotEnvFile($rootDir, $io);
        static::createWritableDirectories($rootDir, $io);

        static::setFolderPermissions($rootDir, $io);
        static::setSecurityKey($rootDir, $io);
    }

    /**
     * Create .env file if it does not exist.
     *
     * @param string $dir The application's root directory.
     * @param \Composer\IO\IOInterface $io IO interface to write to console.
     *
     * @return void
     */
    private static function createDotEnvFile($dir, $io)
    {
        $appLocalConfig = $dir . '/.env';
        $appLocalConfigTemplate = $dir . '/.env.sample';

        if (! file_exists($appLocalConfig)) {
            copy($appLocalConfigTemplate, $appLocalConfig);
            $io->write('Created `.env` file');
        }
    }

    /**
     * Create the `logs` and `tmp` directories.
     *
     * @param string $dir The application's root directory.
     * @param \Composer\IO\IOInterface $io IO interface to write to console.
     * @return void
     */
    private static function createWritableDirectories($dir, $io)
    {
        foreach (static::WRITABLE_DIRS as $path) {
            $path = $dir . '/' . $path;

            if (! file_exists($path)) {
                mkdir($path);
                $io->write('Created `' . $path . '` directory');
            }
        }
    }

    /**
     * Set globally writable permissions on the "tmp" and "logs" directory.
     *
     * This is not the most secure default, but it gets people up and running quickly.
     *
     * @param string $dir The application's root directory.
     * @param \Composer\IO\IOInterface $io IO interface to write to console.
     * @return void
     */
    private static function setFolderPermissions($dir, $io)
    {
        // ask if the permissions should be changed
        if ($io->isInteractive()) {
            $validator = function ($arg) {
                if (in_array($arg, ['Y', 'y', 'N', 'n'])) {
                    return $arg;
                }
                throw new Exception('This is not a valid answer. Please choose Y or n.');
            };
            $setFolderPermissions = $io->askAndValidate(
                '<info>Set Folder Permissions ? (Default to Y)</info> [<comment>Y,n</comment>]? ',
                $validator,
                10,
                'Y'
            );

            if (in_array($setFolderPermissions, ['n', 'N'])) {
                return;
            }
        }

        // Change the permissions on a path and output the results.
        $changePerms = function ($path) use ($io) {
            $currentPerms = fileperms($path) & 0777;
            $worldWritable = $currentPerms | 0007;
            if ($worldWritable == $currentPerms) {
                return;
            }

            $res = chmod($path, $worldWritable);
            if ($res) {
                $io->write('Permissions set on ' . $path);
            } else {
                $io->write('Failed to set permissions on ' . $path);
            }
        };

        $walker = function ($dir) use (&$walker, $changePerms) {
            $files = array_diff(scandir($dir), ['.', '..']);
            foreach ($files as $file) {
                $path = $dir . '/' . $file;

                if (!is_dir($path)) {
                    continue;
                }

                $changePerms($path);
                $walker($path);
            }
        };

        $walker($dir . '/runtime');
        $changePerms($dir . '/runtime');
    }

    /**
     * Set the security.salt value in the application's config file.
     *
     * @param string $dir The application's root directory.
     * @param \Composer\IO\IOInterface $io IO interface to write to console.
     * @return void
     */
    private static function setSecurityKey($dir, $io)
    {
        $newKey = 'base64:HeKO6Uhtl+KyiuxuGyumKmX0oqbDXR2qGtLIRtQFusc='; //hash('sha256', Security::randomBytes(64));
        static::setSecurityKeyInFile($dir, $io, $newKey, '/.env');
    }

    /**
     * Set the security key value in a given file
     *
     * @param string $dir The application's root directory.
     * @param \Composer\IO\IOInterface $io IO interface to write to console.
     * @param string $newKey key to set in the file
     * @param string $file A path to a file relative to the application's root
     * @return void
     */
    private static function setSecurityKeyInFile($dir, $io, $newKey, $file)
    {
        $config = $dir . $file;
        $content = file_get_contents($config);

        $content = str_replace('__KEY__', $newKey, $content, $count);

        if ($count == 0) {
            $io->write('No security key placeholder to replace.');

            return;
        }

        $result = file_put_contents($config, $content);
        if ($result) {
            $io->write('Updated security key value in .env' . $file);

            return;
        }
        $io->write('Unable to update security key value.');
    }

    // https://github.com/maurobonfietti/slim4-api-skeleton/blob/21d78176ed6c0df9fe724a62a78484cb8dd9bd4c/post-create-project-command.php
    public static function thanksReminder(?Event $event = null): void
    {
        $io = $event->getIO();

        $io->writeError('');
        $io->writeError('Try running the command <comment>bin/chiron thanks</> to spread some love!</>');
        $io->writeError('');
    }
}
