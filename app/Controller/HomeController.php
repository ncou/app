<?php

namespace App\Controller;

//use Chiron\Http\Psr\Response;
//use Chiron\Http\Response\HtmlResponse;

use Psr\Container\ContainerInterface;
use Chiron\Views\TemplateRendererInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Chiron\ResponseCreator\ResponseCreator;

final class HomeController
{
    /** @var TemplateRendererInterface */
    private $view;

    public function __construct(TemplateRendererInterface $view)
    {
        $this->view = $view;
    }

    public function index(ResponseCreator $responder): ResponseInterface
    {
        $name = "FOOBAR";

        $this->view->addAttribute('name', $name);

        $content = $this->view->render('hello');

        return $responder->html($content);
    }
}

