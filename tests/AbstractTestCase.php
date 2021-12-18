<?php

declare(strict_types=1);

namespace Tests;

use Chiron\Application;
use Chiron\Core\Directories;
use Chiron\Filesystem\Filesystem;
use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class AbstractTestCase extends BaseTestCase
{
    /** @var Application */
    protected $app;

    protected function setUp(): void
    {
        $root = dirname(__DIR__);

        $paths = [
            'root'    => $root,
            'app'     => $root . '/app',
            'runtime' => $root . '/runtime/tests/', // TODO : utiliser une truc du genre : sys_get_temp_dir() . '/chiron'
            'cache'   => $root . '/runtime/tests/cache/', // TODO : utiliser une truc du genre : sys_get_temp_dir() . '/chiron'
        ];

        $fs = new Filesystem();
        $fs->ensureDirectoryExists($paths['runtime']);
        $fs->ensureDirectoryExists($paths['cache']);

        $this->app = $this->makeApp($paths);
    }

    // TODO : méthode à virer si on utilise directement le répertoire temporaire du systéme d'exploitation.
    protected function tearDown(): void
    {
        $fs = new Filesystem();

        $runtime = $this->app->get(Directories::class)->get('@runtime');

        if ($fs->isDirectory($runtime)) {
            $fs->deleteDirectory($runtime);
        }
    }

    protected function makeApp(array $paths): Application
    {
        $app = new TestApp($paths, []);
        $app->boot();

        return $app;
    }
}
