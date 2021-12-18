<?php

declare(strict_types=1);

namespace Tests\Traits;

use Chiron\Http\Http;
use Nyholm\Psr7\ServerRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

trait InteractsWithHttpTrait
{
    protected function handleRequest(ServerRequestInterface $request): ResponseInterface
    {
        return $this->http()->handle($request);
    }

    protected function http(): Http
    {
        return $this->app->get(Http::class);
    }

    // TODO : attacher automatiquement le base_path à l'uri !!!
    // https://github.com/clue/reactphp-buzz/blob/2d4c93be8cba9f482e96b8567916b32c737a9811/src/Message/MessageFactory.php#L120
    protected function createRequest(string $method, $uri, array $serverParams = []): ServerRequestInterface
    {
        return new ServerRequest($method, $uri, [], null, '1.1', $serverParams);
    }
}
