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
use Chiron\Routing\RouteCollection;
use Chiron\Container\BindingInterface;

use Chiron\Facade\Routing;
use Chiron\Facade\Target;

use Chiron\Http\MiddlewareQueue;
use App\Middleware\XClacksOverheadMiddleware;

class AddMiddlewareBootloader extends AbstractBootloader
{
    public function boot(MiddlewareQueue $middlewares)
    {
        $middlewares->addMiddleware(XClacksOverheadMiddleware::class);
    }

}

