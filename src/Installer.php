<?php

declare(strict_types=1);

namespace App;

use Chiron\Core\Core;
use Chiron\Support\Random;
use Composer\Composer;
use Composer\Factory;
use Composer\IO\IOInterface;
use Composer\Script\Event;
use Composer\Script\ScriptEvents;
use LogicException;

// TODO : ajouter des tests : exemple :
//https://github.com/mezzio/mezzio-skeleton/blob/51cf896c4d14c4b4c76427986a576c214583979b/test/MezzioInstallerTest/OptionalPackagesTestCase.php#L168
//https://github.com/mezzio/mezzio-skeleton/blob/51cf896c4d14c4b4c76427986a576c214583979b/test/MezzioInstallerTest/AddPackageTest.php#L21
//https://github.com/mezzio/mezzio-skeleton/blob/51cf896c4d14c4b4c76427986a576c214583979b/test/MezzioInstallerTest/ProjectSandboxTrait.php#L69
//https://github.com/mezzio/mezzio-skeleton/blob/51cf896c4d14c4b4c76427986a576c214583979b/test/MezzioInstallerTest/CopyResourceTest.php#L33
// Un bouchon pour les questions :
//https://github.com/mezzio/mezzio-skeleton/blob/407b4869134f1a42c630c80a17956ec130c4e5d4/test/MezzioInstallerTest/RequestInstallTypeTest.php#L40
//https://github.com/mezzio/mezzio-skeleton/blob/407b4869134f1a42c630c80a17956ec130c4e5d4/test/MezzioInstallerTest/PromptForOptionalPackagesTest.php#L75


//https://github.com/mezzio/mezzio-skeleton/blob/3.12.x/src/MezzioInstaller/OptionalPackages.php

// Execute command :
//https://github.com/sensiolabs/SensioDistributionBundle/blob/master/Composer/ScriptHandler.php#L282
//https://github.com/veewee/composer-run-parallel/blob/e776154c2910cdc0b3b4400196fd2aa0b3da7251/src/Executor/AsyncTaskExecutor.php
//https://github.com/symfony/flex/blob/375e01daedd481501c29f3dea443cf885858382f/src/ScriptExecutor.php#L58

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

//https://github.com/cakephp/app/blob/4.x/src/Console/Installer.php

//https://github.com/yiisoft/app/blob/master/src/Installer.php#L22

// TODO : vider le cache, exemple de code avec un glob() qui liste les fichiers il suffira ensuite de faire un @unlink sur les fichiers !!!!
//https://github.com/laravel/framework/blob/b9203fca96960ef9cd8860cb4ec99d1279353a8d/src/Illuminate/Foundation/Console/ViewClearCommand.php#L69
//https://github.com/chubbyphp/chubbyphp-clean-directories/blob/master/src/Command/CleanDirectoriesCommand.php#L63
//https://github.com/dimanzver/assets-deployeer/blob/master/lib/FileManager.php#L37

//array_map('unlink', glob($this->cacheDir.'/*'));

/**
 * Provides installation hooks for when this application is installed through
 * composer. Customize this class to suit your needs.
 */
final class Installer
{
    /**
     * An array of directories to be made writable
     */
    // TODO : il faudrait plutot aller chercher les infos dans le fichier bootstrap.php pour récupérer le chemin via '@runtime' et '@cache', le répertoire de log on s'en fiche ou alors il faut l'ajouter dans le fichier bootstrap + ajouter une dépendance vers chiron/logger !!!!
    private const WRITABLE_DIRS = [
        'runtime',
        'runtime/cache',
    ];

    private Composer $composer;
    private IOInterface $io;
    private string $projectRoot;

    public function __construct(IOInterface $io, Composer $composer, string $projectRoot)
    {
        $this->io = $io;
        $this->composer = $composer;

        // TODO : récupérer la commande (ex : update / create-project ...etc) pour ne créer les répertoires que dans certains cas. Par exemple lors de la commande "du" ou "dump-update" pas la peine de créer les répertoires !!!!

        //https://github.com/symfony/flex/blob/2.x/src/Flex.php#L314
        //ex :  if (ScriptEvents::POST_UPDATE_CMD === $event->getName()) { ... }
        //ex : https://github.com/symfony/flex/blob/2.x/src/Flex.php#L148

        // https://github.com/symfony/flex/blob/2.x/src/Flex.php#L148
        // https://github.com/symfony/thanks/blob/main/src/Thanks.php#L49
        // https://github.com/narrowspark/automatic-composer-prefetcher/blob/master/Plugin.php#L375

        // Get composer.json location
        //$composerFile = realpath(Factory::getComposerFile());

        // Calculate project root from composer.json, if necessary
        //$this->projectRoot = $projectRoot ?? dirname($composerFile);

        $this->projectRoot = rtrim($projectRoot, '/\\') . '/';

        // TODO : on peut aussi faire un getcwd je pense : utiliser la classe Composer : Platform::getCwd(true)   => https://github.com/composer/composer/blob/be4b70ce79b34762acf1647e63108fdcca7f758b/src/Composer/Factory.php#L168
        // TODO : utiliser ce bout de code ???     $projectDir = \dirname(realpath(Factory::getComposerFile()));
        //$this->projectRoot = dirname(__DIR__) . DIRECTORY_SEPARATOR;

        // TODO : utiliser un noralizePath dans le librairie Filesystem qui est installée avec Composer :
        //https://github.com/composer/composer/blob/854aab5f0393f39f0dc83500fee3516ccea9cc7f/src/Composer/Package/Archiver/ArchivableFilesFinder.php#L47
        //https://github.com/composer/composer/blob/076925ebefaab6f13e5834f8025a728691aac175/src/Composer/Repository/FilesystemRepository.php#L245
    }

    /**
     * Does some routine installation tasks so people don't have to.
     *
     * @param \Composer\Script\Event $event The composer event object.
     *
     * @return void
     *
     * @codeCoverageIgnore
     */
    public static function install(Event $event): void
    {
        // Calculate project root from composer.json file.
        $root = dirname(realpath(Factory::getComposerFile()));

        $installer = new self($event->getIO(), $event->getComposer(), $root);

        $installer->io->write('<info>Setting up application structure.</info>');

        // TODO : ajouter aussi une méthode pour purger le répertoire du cache !!!! eventuellement regarder la méthode $this->filesystem->emptyDirectory($path);
        $installer->createDirectories();
        $installer->updatePermissions();
        $installer->createDotEnvFile();
        $installer->setSecurityKey(Random::bytes());

        if ($event->getName() === ScriptEvents::POST_CREATE_PROJECT_CMD) {
            $installer->displayThanksMessage();
        }
    }

    /**
     * Create some writable directories.
     *
     * @return void
     */
    public function createDirectories(): void
    {
        // TODO : une simple méthode $this->filesystem->ensureDirectoryExists($temporaryDir);  devrait suffire !!!
        foreach (static::WRITABLE_DIRS as $path) {
            $path = $this->projectRoot . $path;

            if (! file_exists($path)) {
                mkdir($path);
                $this->io->write(sprintf('Created "%s" directory', $path)); // TODO : utiliser une fonction du genre Path::normalize() pour éviter d'afficher une truc du genre D:\xxx\runtime/cache
            }
        }
    }

    /**
     * Set globally writable permissions on the "tmp" and "logs" directory.
     *
     * This is not the most secure default, but it gets people up and running quickly.
     *
     * @throws LogicException Exception raised by validator.
     *
     * @return void
     */
    public function updatePermissions(): void
    {
        // TODO : mettre cette partie interactive dans un bloc de non converture de tests. // @codeCoverageIgnoreStart   // @codeCoverageIgnoreEnd
        // ask if the permissions should be changed
        if ($this->io->isInteractive()) {
            $validator = function ($arg) {
                if (in_array($arg, ['Y', 'y', 'N', 'n'])) {
                    return $arg;
                }

                throw new LogicException('This is not a valid answer. Please choose Y or n.');
            };
            $setFolderPermissions = $this->io->askAndValidate(
                '<info>Set Folder Permissions ? (Default to Y)</info> [<comment>Y,n</comment>]? ',
                $validator,
                attempts: 10,
                default: 'Y'
            );

            if (in_array($setFolderPermissions, ['n', 'N'])) {
                return;
            }
        }

        // Change the permissions on a path and output the results.
        $changePerms = function ($path): void {
            $currentPerms = fileperms($path) & 0777;
            $worldWritable = $currentPerms | 0007;
            if ($worldWritable === $currentPerms) {
                return;
            }

            chmod($path, $worldWritable);
            $this->io->write('Permissions set on ' . $path);
        };

        // TODO : remplacer cela par une boucle sur l'Iterator : $filesystem->directories(): Traversable
        $walker = function ($dir) use (&$walker, $changePerms): void {
            $files = array_diff(scandir($dir), ['.', '..']);
            foreach ($files as $file) {
                $path = $dir . $file;

                if (! is_dir($path)) {
                    continue;
                }

                $changePerms($path);
                $walker($path);
            }
        };

        $walker($this->projectRoot . 'runtime');
        $changePerms($this->projectRoot . 'runtime');
        $changePerms($this->projectRoot . 'public/assets');
    }

    /**
     * Create .env file if it does not exist.
     *
     * @return void
     */
    public function createDotEnvFile(): void
    {
        $envFile = $this->projectRoot . '.env';
        $envFileTemplate = $this->projectRoot . '.env.sample';

        if (! file_exists($envFile)) {
            copy($envFileTemplate, $envFile);
            $this->io->write('Created ".env" file');
        }
    }

    /**
     * Set the security key value in the .env file
     *
     * @param string $key Random bytes string to use as key
     *
     * @return void
     */
    public function setSecurityKey(string $key): void
    {
        // TODO : créer dans la classe Random une méthode base64() et base64Safe() avec en 2éme paramétre un préfix qui pourrait être concaténé à la chaine créée.
        $key = 'base64:' . base64_encode($key);

        $path = $this->projectRoot . '.env';
        $content = file_get_contents($path);

        // Replace the placeholder with the real key.
        $content = str_replace('__KEY__', $key, $content, $count);
        if ($count === 0) {
            $this->io->write('No security key placeholder to replace.');

            return;
        }

        file_put_contents($path, $content);
        $this->io->write('Updated security key value in .env file');
    }

    // https://github.com/maurobonfietti/slim4-api-skeleton/blob/21d78176ed6c0df9fe724a62a78484cb8dd9bd4c/post-create-project-command.php
    public function displayThanksMessage(): void
    {
        $this->io->write(ltrim(Core::BANNER_LOGO, "\n")); // TODO : créer une méthode dans la classe Core::getLogo(newLine: false) qui se charge de faire le ltrim !!!
        $this->io->write('Thanks for installing this project!'); // TODO : utiliser le tag <comment></comment> ou <fg=green>foo</> par exemple pour colorer le texte ???
    }
}
