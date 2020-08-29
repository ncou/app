<?php

declare(strict_types=1);

namespace Tests;

use Chiron\Boot\Directories;
use Chiron\Application;
use Chiron\Http\Http;
use Chiron\Filesystem\Filesystem;
use Nyholm\Psr7\ServerRequest;
use Psr\Http\Message\ServerRequestInterface;

class HttpTest extends TestCase
{
    public function testAppHttp()
    {
        $request = $this->request('GET', '/');

        $response = $this->http->run($request);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertStringContainsString('', (string) $response->getBody());
    }
}
