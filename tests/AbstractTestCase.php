<?php

declare(strict_types=1);

namespace Tests;

use Chiron\Application;
use Chiron\Core\Directories;
use Chiron\Console\Console;
use Chiron\Filesystem\Filesystem;
use Chiron\Http\Http;
use Nyholm\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase as BaseTestCase;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractTestCase extends BaseTestCase
{
    /** @var Application */
    protected $app;
    /** @var Http */
    protected $http;

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
        $this->http = $this->http(); // TODO : il faudrait faire la même chose et stocker l'instance de la console !!!!
    }

    // TODO : méthode à virer si on utilise directement le répertoire temporaire du systéme d'exploitation.
    protected function tearDown(): void
    {
        $fs = new Filesystem();

        $runtime = $this->app->services->container->get(Directories::class)->get('@runtime');

        if ($fs->isDirectory($runtime)) {
            $fs->deleteDirectory($runtime);
        }
    }

    protected function http(): Http
    {
        return $this->app->services->container->get(Http::class);
    }

    protected function makeApp(array $paths): Application
    {
        $app = new Application($paths, []);
        $app->services->boot();

        return $app;
    }

    // TODO : attacher automatiquement le base_path à l'uri !!!
    // https://github.com/clue/reactphp-buzz/blob/2d4c93be8cba9f482e96b8567916b32c737a9811/src/Message/MessageFactory.php#L120
    protected function request(string $method, $uri, array $serverParams = []): ServerRequestInterface
    {
        return new ServerRequest($method, $uri, [], null, '1.1', $serverParams);
    }

    protected function runCommandDebug(string $command, array $args = [], ?OutputInterface $output = null): string
    {
        $output = $output ?? new BufferedOutput();
        $output->setVerbosity(BufferedOutput::VERBOSITY_VERBOSE);

        return $this->runCommand($command, $args, $output);
    }

    protected function runCommandVeryVerbose(string $command, array $args = [], ?OutputInterface $output = null): string
    {
        $output = $output ?? new BufferedOutput();
        $output->setVerbosity(BufferedOutput::VERBOSITY_DEBUG);

        return $this->runCommand($command, $args, $output);
    }

    protected function runCommand(string $command, array $args = [], ?OutputInterface $output = null): string
    {
        array_unshift($args, $command);

        $input = new ArrayInput($args);
        $output = $output ?? new BufferedOutput();

        $this->console()->run($input, $output);

        return $output->fetch();
    }

    protected function console(): Console
    {
        return $this->app->services->container->get(Console::class);
    }
}
