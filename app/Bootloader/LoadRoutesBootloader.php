<?php

namespace App\Bootloader;

//use Chiron\Http\Psr\Response;
use Chiron\Http\Response\HtmlResponse;

use Psr\Container\ContainerInterface;
use Chiron\Views\TemplateRendererInterface;
use Chiron\Container\Container;
use Chiron\Bootload\AbstractBootloader;
use LogicException;
use SplFileInfo;
use Symfony\Component\Finder\Finder;
use Chiron\Config\Config;
use Dotenv\Dotenv;
use Dotenv\Environment\DotenvFactory;
use Dotenv\Exception\InvalidFileException;
use Dotenv\Environment\Adapter\PutenvAdapter;
use Dotenv\Environment\Adapter\EnvConstAdapter;
use Dotenv\Environment\Adapter\ServerConstAdapter;
use Chiron\Boot\DirectoriesInterface;
use Chiron\Router\RouterInterface;
use Psr\Http\Message\ServerRequestInterface;
use Chiron\Router\Target\Controller;
use Chiron\Router\Target\Group;
use Chiron\Router\Target\Namespaced;
use Chiron\Router\Target\Callback;
use Chiron\Router\Target\Action;
use Chiron\Router\Target\TargetFactory;
use Chiron\Router\Route;
use Chiron\Router\RouteCollector;
use Chiron\Container\BindingInterface;

use Chiron\Facade\Routing;
use Chiron\Facade\Target;

class LoadRoutesBootloader extends AbstractBootloader
{


    public function boot(RouteCollector $routing, TargetFactory $target)
    {
        //https://github.com/laravel/framework/blob/master/src/Illuminate/Foundation/Bootstrap/RegisterFacades.php
        /*
        $loader = \Chiron\Facade\AliasLoader::getInstance();
        $loader->alias('Routing','\Chiron\Facade\Routing');
        $loader->register();
*/

        //$routing->get('/{action}')->to(Target::action('\Controllers\MainController', 'index'))->name('home');

        //$routing->any('/{action}')->to(new Action($container, \Controllers\MainController::class, ['index', 'toto']))->name('home')->requireHttp()->method('GET', 'POST', 'PUT')->middleware(new \Middlewares\MiddlewareOne());
        //Routing::any('/{action}')->to($target->action(\Controllers\MainController::class, ['index', 'toto']))->name('home')->requireHttp()->method('GET', 'POST', 'PUT')->middleware(new \Middlewares\MiddlewareOne());

        //Routing::redirect('/tonton', '/foobar');
        //Routing::view('/tonton', 'test');

        //Routing::any('/{action}')->to($target->action(\Controllers\MainController::class, ['index', 'toto']));
        //Routing::any('/{action}')->to($target->action('\Controllers\MainController', 'index'));

        //Routing::post('/{action}')->to(Target::action('\Controllers\MainController', 'index'))->name('home');

        //Routing::get('/{action}')->to(Target::action('\Controllers\MainController', 'index'))->name('home');

        Routing::get('/{action}')->to(Target::callback([\App\Controller\MainController::class, 'index']));

        //$routing->view('/test', 'test');
    }

}

