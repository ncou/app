<?php

declare(strict_types=1);

namespace Tests;

class HttpTest extends AbstractTestCase
{
    public function testAppHttp()
    {
        $request = $this->request('GET', '/');

        $response = $this->http->run($request);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertStringContainsString('', (string) $response->getBody());
    }
}
