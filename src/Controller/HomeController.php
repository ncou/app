<?php

declare(strict_types=1);

namespace App\Controller;

use Chiron\Assets\AssetManager;
use Chiron\ResponseCreator\Traits\ResponseCapableInterface;
use Chiron\ResponseCreator\Traits\ResponseCapableTrait;
use Chiron\Translator\TranslatorInterface;
use Chiron\View\ViewManager;
use Psr\Http\Message\ResponseInterface;

final class HomeController implements ResponseCapableInterface
{
    use ResponseCapableTrait;

    public function index(ViewManager $views, TranslatorInterface $translator): ResponseInterface
    {
        $view = $views->get('home');

        $view->assign('title', $translator->trans('site.title'));
        $view->assign('quote', $translator->trans('quote.content'));
        $view->assign('author', $translator->trans('quote.author'));

        // TODO : code temporaire ajouter dans le fichier de config une section "dependencies[]" avec des références vers le container.
        // TODO : renommer la variable $result en $body
        $result = $view->render([
            'assetManager' => container(AssetManager::class),
            'translator'   => $translator,
        ]);

        return $this->getResponder()->html($result); // TODO : renommer getResponder() en responder.
    }
}
