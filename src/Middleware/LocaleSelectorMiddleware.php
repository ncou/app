<?php

declare(strict_types=1);

namespace App\Middleware;

use Chiron\Translator\TranslatorInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

//https://github.com/contributte/translation/blob/master/src/LocalesResolvers/Header.php#L37
//https://github.com/nette/http/blob/17314395a830257e5db7167d5cccd1e6d1183ac9/src/Http/Request.php#L274

/**
 * Sets the runtime default locale for the request based on the
 * Accept-Language header. The default will only be set if it
 * matches the list of available locales.
 */
class LocaleSelectorMiddleware implements MiddlewareInterface
{
    private TranslatorInterface $translator;

    /**
     * @var string[]
     */
    private array $availableLocales = [];

    /**
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->availableLocales = $translator->getCatalogueManager()->getLocales();
        $this->translator = $translator;
    }

    /**
     * @param ServerRequestInterface  $request
     * @param RequestHandlerInterface $handler
     *
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $defaultLocale = $this->translator->getLocale();

        try {
            foreach ($this->fetchLocales($request) as $locale) {
                // TODO : récupérer seulement les 2 premiers caractéres de la locale au cas ou on est un truc du genre fr_FR ou fr-FR. Et faire attention si on a seulement une "*" car cela peut exister dans le header un truc genre "Accept-Language = '*;q=0.9, fr-FR'"
                // TODO : vérifier l'utilité du "" car si on a une chaine vide le in_array retournera false donc on ne retrera pas dans le if, ce contrôle chaine vide semble redondant !!!
                if ($locale !== '' && in_array($locale, $this->availableLocales)) {
                    $this->translator->setLocale($locale);

                    break;
                }
            }

            return $handler->handle($request);
        } finally {
            // Restore original locale.
            $this->translator->setLocale($defaultLocale);
        }
    }

    /**
     * @param ServerRequestInterface $request
     *
     * @return iterable<int, string>
     */
    // TODO : gérer le sort selon le coefficient de quality utilisé dans le header ex: 'fr;q=0.5, en;q=0.9' + renommer la méthode en extractLanguage si on retour un tableau plutot qu'un iterator, et il faudra récupérer que les 2 premiers caractéres (sauf si on est dans la cas du wildcard "*" et dans ce cas on aura pas deux caractéres, je pense qu'il faudra retourner une chaine vide dans ce cas là)
    public function fetchLocales(ServerRequestInterface $request): iterable
    {
        $header = $request->getHeaderLine('Accept-Language');

        foreach (explode(',', $header) as $value) {
            $length = strpos($value, ';');
            if ($length !== false) {
                yield trim(substr($value, 0, $length));
            } else {
                yield $value;
            }
        }
    }
}
