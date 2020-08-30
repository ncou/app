<?php

namespace App\Controller;

//use Chiron\Http\Psr\Response;
//use Chiron\Http\Response\HtmlResponse;

use Psr\Container\ContainerInterface;
use Chiron\Views\TemplateRendererInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class HomeController
{
    /**
     * Dependency injection container
     *
     * @var ContainerInterface
     */
    private $container;

    // TODO : lui passer plutot en paramétre le container, mais dans ce cas il faut pouvoir externaliser le container !!!!
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        // TODO : initialiser la view/renderer directement dans le fichier "dependencies.php" ?????
        $this->view = $container->get(TemplateRendererInterface::class);
    }

    public function index(ServerRequestInterface $request): ResponseInterface
    {
        $name = "FOOBAR";

        $this->view->addAttribute('name', $name);

        $content = $this->view->render('hello');
        $response = $this->createResponse($content, 200, ['Content-Type' => 'text/html']);

        return $response;
    }

    // TODO : vérifier que cela ne pose pas de problémes si on passe un content à null, si c'est le cas initialiser ce paramétre avec chaine vide.
    private function createResponse(string $content = null, int $statusCode = 200, array $headers = []): ResponseInterface
    {
        $responseFactory = $this->container->get('Psr\Http\Message\ResponseFactoryInterface');
        $response = $responseFactory->createResponse($statusCode);

        foreach ($headers as $name => $value) {
            $response = $response->withHeader($name, $value);
        }

        $response->getBody()->write($content);

        return $response;
    }
}

