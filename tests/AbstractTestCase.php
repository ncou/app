<?php

declare(strict_types=1);

namespace Tests;

use Chiron\Application;
use Chiron\Console\Console;
use Chiron\Core\Directories;
use Chiron\Dev\Tools\TestSuite\AbstractTestCase as DevtoolsTestCase;
use Chiron\Filesystem\Filesystem;
use Chiron\Http\Http;
use Chiron\Testing\Traits\InteractsWithConsoleTrait;
use Chiron\Testing\Traits\InteractsWithHttpTrait;
use Nyholm\Psr7\ServerRequest;

// TODO : améliorer l'interaction avec le HTML.
//https://github.com/laravel/browser-kit-testing/blob/5cbb537f5685eeee47f91a95efa8dc493d97dfb5/src/Concerns/InteractsWithPages.php#L296

// TODO : améliorer les assert pour la response :
//https://github.com/illuminate/testing/blob/master/TestResponse.php
//https://github.com/laravel/browser-kit-testing/blob/5cbb537f5685eeee47f91a95efa8dc493d97dfb5/src/TestResponse.php

// TODO : interaction avec la console
//https://github.com/illuminate/testing/blob/master/PendingCommand.php

// TODO : ajouter des assert autour du container : https://github.com/spiral/testing/blob/fd6373159193602db8f012368e4e4734f8c93af1/src/Traits/InteractsWithCore.php

// TODO : permettre de modifier les variables d'environnement : https://github.com/spiral/testing/blob/fd6373159193602db8f012368e4e4734f8c93af1/src/Traits/InteractsWithCore.php#L134

//TODO : regarder les fonctions utiles ici (assertTextNotContains, assertTextEndsWith, assertFileDoesNotExist, skipIf ...etc)
//https://github.com/cakephp/cakephp/blob/5.x/src/TestSuite/TestCase.php
//https://github.com/cakephp/cakephp/blob/5.x/src/TestSuite/StringCompareTrait.php
// TODO : vérifier quand même que ces nouveaux assert ne sont pas des doublons de ce qui existe déjà dans PHPUNIT : https://github.com/sebastianbergmann/phpunit/blob/master/src/Framework/Assert.php

// TODO : initialiser une propriété de classe "public const ENV = []" pour overwriter les valeurs d'environement lorsqu'on fera un extends de cette classe.
//https://github.com/spiral/testing/blob/fd6373159193602db8f012368e4e4734f8c93af1/src/TestCase.php#L27
//https://github.com/spiral/testing/blob/fd6373159193602db8f012368e4e4734f8c93af1/src/TestCase.php#L119

/*
Extraire le code des tests dans un package chiron/testing et ajouter dans le composer une rubrique "suggest" pour le package http ou session ou cookie...etc selon les traits qu'on aura fait et pour éviter de mettre ces packages dans la section "require" du fichier composer.

ex : https://github.com/illuminate/testing/blob/master/composer.json#L33
*/

abstract class AbstractTestCase extends DevtoolsTestCase
{
    use InteractsWithConsoleTrait;
    use InteractsWithHttpTrait;

    /** @var Application */
    protected Application $app;

    // TODO : je pense que c'est plutot une méthode setUpBeforeClass cad qui doit être appellé une seule fois pour la classe de test !!!
    protected function setUp(): void
    {
        $root = dirname(__DIR__);

        $paths = [
            'root'    => $root,
            //'app'     => $root . '/src/',
            //'runtime' => $root . '/runtime/tests/', // TODO : utiliser une truc du genre : sys_get_temp_dir() . '/chiron'
            //'cache'   => $root . '/runtime/tests/cache/', // TODO : utiliser une truc du genre : sys_get_temp_dir() . '/chiron'
        ];

/*
        $fs = new Filesystem();
        $fs->ensureDirectoryExists($paths['runtime']);
        $fs->ensureDirectoryExists($paths['cache']);
*/
        $this->app = $this->makeApp($paths);
    }

    // TODO : méthode à virer si on utilise directement le répertoire temporaire du systéme d'exploitation.
    // TODO : je pense que c'est plutot une méthode tearDownAfterClass cad qui doit être appellé une seule fois pour la classe de test !!!
    protected function tearDown(): void
    {
        /*
        $fs = new Filesystem();

        $runtime = $this->app->get(Directories::class)->get('@runtime');

        if ($fs->isDirectory($runtime)) {
            $fs->deleteDirectory($runtime);
        }*/
    }

    protected function makeApp(array $paths): Application
    {
        $app = new TestApp($paths, ['APP_DEBUG' => true]);
        $app->boot();

        return $app;
    }

    // Method needed for the interacts trait.
    protected function console(): Console
    {
        return $this->app->get(Console::class);
    }

    // Method needed for the interacts trait.
    protected function http(): Http
    {
        return $this->app->get(Http::class);
    }

    /**
     * @param string                               $method       HTTP method
     * @param string|UriInterface                  $uri          URI
     * @param array                                $headers      Request headers
     * @param string|resource|StreamInterface|null $body         Request body
     * @param string                               $version      Protocol version
     * @param array                                $serverParams Typically the $_SERVER superglobal
     */
    protected function handleRequest(string $method, string|UriInterface $uri, array $headers = [], $body = null, string $version = '1.1', array $serverParams = []): void
    {
        $request = new ServerRequest(
            $method,
            $uri,
            $headers,
            $body,
            $version,
            $serverParams
        );

        // Execute the interacts http trait method.
        $this->runRequest($request);
    }
}
