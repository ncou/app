<?php

declare(strict_types=1);

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

//https://github.com/heiglandreas/X-Clacks-Overhead/blob/master/src/ClacksMiddleware.php

/**
 * @see https://xclacksoverhead.org/home/about
 */
class XClacksOverheadMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);

        return $response->withHeader('X-Clacks-Overhead', 'GNU Terry Pratchett');
    }
}
