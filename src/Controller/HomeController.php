<?php

declare(strict_types=1);

namespace App\Controller;

use Chiron\ResponseCreator\ResponseCreator;
use Chiron\Views\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;

final class HomeController
{
    /** @var TemplateRendererInterface */
    private $template;

    public function __construct(TemplateRendererInterface $template)
    {
        $this->template = $template;
    }

    public function index(ResponseCreator $responder): ResponseInterface
    {
        $name = 'FOOBAR';

        $this->template->addAttribute('name', $name);

        $content = $this->template->render('hello');

        return $responder->html($content);
    }
}
