<?php

declare(strict_types=1);

namespace Tests;

use App\Installer;
use Chiron\Core\Core;
use Chiron\Dev\Tools\TestSuite\AbstractTestCase;
use Composer\Composer;
use Composer\IO\IOInterface;

//https://github.com/mezzio/mezzio-skeleton/blob/51cf896c4d14c4b4c76427986a576c214583979b/test/MezzioInstallerTest/OptionalPackagesTestCase.php#L168

class InstallerTest extends AbstractTestCase
{
    private IOInterface $io;
    private Composer $composer;
    private const APPLICATION_ROOT = __DIR__ . '/Fixtures/app/';

    public function testCreateDotEnvFile(): void
    {
        // clear the fixtures .env file if it exist.
        if (is_file(self::APPLICATION_ROOT . '.env')) {
            unlink(self::APPLICATION_ROOT . '.env');
        }

        $installer = $this->createInstaller();

        $this->assertFileDoesNotExist(self::APPLICATION_ROOT . '.env');

        $this->io->shouldReceive('write')->once()->with('Created ".env" file');
        $installer->createDotEnvFile();

        $this->assertFileExists(self::APPLICATION_ROOT . '.env');

        $this->assertFileEquals(
            self::APPLICATION_ROOT . '.env.sample',
            self::APPLICATION_ROOT . '.env',
        );

        // call again the create dot env file, to be sure nothing is done.
        $this->io->shouldReceive('write')->never();
        $installer->createDotEnvFile();
    }

    public function testSetSecurityKey(): void
    {
        $installer = $this->createInstaller();

        $this->assertFileExists(self::APPLICATION_ROOT . '.env');
        $this->assertStringContainsString('__KEY__', file_get_contents(self::APPLICATION_ROOT . '.env'));

        $this->io->shouldReceive('write')->once()->with('Updated security key value in .env file');
        $installer->setSecurityKey('secret_key');

        // call again the set security key, to be sure the key placeholder is not present.
        $this->io->shouldReceive('write')->once()->with('No security key placeholder to replace.');
        $installer->setSecurityKey('secret_key');
    }

    public function testCreateDirectories(): void
    {
        // clear the fixtures runtime folder if it exist.
        if (is_dir(self::APPLICATION_ROOT . 'runtime/cache')) {
            rmdir(self::APPLICATION_ROOT . 'runtime/cache');
        }
        if (is_dir(self::APPLICATION_ROOT . 'runtime')) {
            rmdir(self::APPLICATION_ROOT . 'runtime');
        }

        $installer = $this->createInstaller();

        $this->io->shouldReceive('write')->with('Created "' . self::APPLICATION_ROOT . 'runtime' . '" directory');
        $this->io->shouldReceive('write')->with('Created "' . self::APPLICATION_ROOT . 'runtime/cache' . '" directory');

        $this->assertDirectoryDoesNotExist(self::APPLICATION_ROOT . 'runtime');
        $this->assertDirectoryDoesNotExist(self::APPLICATION_ROOT . 'runtime/cache');

        $installer->createDirectories();

        $this->assertDirectoryExists(self::APPLICATION_ROOT . 'runtime');
        $this->assertDirectoryExists(self::APPLICATION_ROOT . 'runtime/cache');
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
            __DIR__ . '/Fixtures/app'
        );
    }
}
