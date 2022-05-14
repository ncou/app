<?php

declare(strict_types=1);

namespace Tests;

use App\Installer;
use Composer\Composer;
use Composer\IO\IOInterface;

class InstallerTest extends AbstractTestCase
{
    private IOInterface $io;
    private Composer $composer;

    public function testInstaller()
    {
        $installer = $this->createInstaller();

/*
        $this->io
            ->expects($this->atLeast(2))
            ->method('write')
            ->withConsecutive(
                [$this->stringContains('Removing installer development dependencies')],
                [$this->stringContains('Adding package')],
            );
            */
    }

    protected function createInstaller()
    {

        $this->io = $this->mockery(IOInterface::class);
        $this->composer = $this->mockery(Composer::class);

/*
        $this->io = $this->createMock(IOInterface::class);
        $this->composer = $this->createMock(Composer::class);


        $this->io
            ->expects($this->atLeast(2))
            ->method('write')
            ->withConsecutive(
                [$this->stringContains('Removing installer development dependencies')],
                [$this->stringContains('Adding package')],
            );
*/




        $installer = new Installer(
            $this->io,
            $this->composer
        );
    }
}
