<?php

declare(strict_types=1);

namespace Tests;

use App\Installer;
use Chiron\Core\Core;
use Chiron\Dev\Tools\TestSuite\AbstractTestCase;
use Composer\Composer;
use Composer\IO\IOInterface;
use Chiron\Filesystem\Filesystem;

//https://github.com/mezzio/mezzio-skeleton/blob/51cf896c4d14c4b4c76427986a576c214583979b/test/MezzioInstallerTest/OptionalPackagesTestCase.php#L168

class InstallerTest extends AbstractTestCase
{
    private IOInterface $io;
    private Composer $composer;
    private static string $tempDir;

    public static function setUpBeforeClass(): void
    {
        // TODO : créer dans la classe Filesystem une méthode tempDirectory et tempFilename pour générer des noms de répertoire/fichiers aléatoire ??? https://github.com/spiral/framework/blob/23299ff3442a9334494b9481b9adbd2b4a317907/src/Files/src/Files.php#L361
        $tempName = mt_rand().'-'.str_replace([' ', '.'], '', microtime());
        static::$tempDir = sys_get_temp_dir() . '/' . $tempName . '/';

        mkdir(static::$tempDir, 0777, true);

        copy(__DIR__ . '/../.env.sample', static::$tempDir . '.env.sample');
    }

    public static function tearDownAfterClass(): void
    {
        $fs = new Filesystem();

        if ($fs->isDirectory(static::$tempDir)) {
            $fs->deleteDirectory(static::$tempDir);
        }
    }

    public function testCreateDotEnvFile(): void
    {
        $installer = $this->createInstaller();

        $this->assertFileDoesNotExist(static::$tempDir . '.env');

        $this->io->shouldReceive('write')->once()->with('Created ".env" file');
        $installer->createDotEnvFile();

        $this->assertFileExists(static::$tempDir . '.env');

        $this->assertFileEquals(
            static::$tempDir . '.env.sample',
            static::$tempDir . '.env',
        );

        // call again the create dot env file, to be sure nothing is done.
        $this->io->shouldReceive('write')->never();
        $installer->createDotEnvFile();
    }

    public function testSetSecurityKey(): void
    {
        $installer = $this->createInstaller();

        $this->assertFileExists(static::$tempDir . '.env');
        $this->assertStringContainsString('__KEY__', file_get_contents(static::$tempDir . '.env'));

        $this->io->shouldReceive('write')->once()->with('Updated security key value in .env file');
        $installer->setSecurityKey('secret_key');

        // call again the set security key, to be sure the key placeholder is not present.
        $this->io->shouldReceive('write')->once()->with('No security key placeholder to replace.');
        $installer->setSecurityKey('secret_key');
    }

    public function testCreateDirectories(): void
    {
        $installer = $this->createInstaller();

        $this->io->shouldReceive('write')->with('Created "' . static::$tempDir . 'runtime' . '" directory');
        $this->io->shouldReceive('write')->with('Created "' . static::$tempDir . 'runtime/cache' . '" directory');

        $this->assertDirectoryDoesNotExist(static::$tempDir . 'runtime');
        $this->assertDirectoryDoesNotExist(static::$tempDir . 'runtime/cache');

        $installer->createDirectories();

        $this->assertDirectoryExists(static::$tempDir . 'runtime');
        $this->assertDirectoryExists(static::$tempDir . 'runtime/cache');
    }

    public function testDisplayThanksMessage(): void
    {
        $installer = $this->createInstaller();

        $this->io->shouldReceive('write')->with(ltrim(Core::BANNER_LOGO, "\n"));
        $this->io->shouldReceive('write')->with('Thanks for installing this project!');

        $installer->displayThanksMessage();
    }

    protected function createInstaller(): Installer
    {
        $this->io = $this->mockery(IOInterface::class);
        $this->composer = $this->mockery(Composer::class);

        return new Installer(
            $this->io,
            $this->composer,
            static::$tempDir
        );
    }
}
