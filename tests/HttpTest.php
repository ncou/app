<?php

declare(strict_types=1);

namespace Tests;

use Tests\Traits\InteractsWithHttpTrait;

class HttpTest extends AbstractTestCase
{
    use InteractsWithHttpTrait;

    public function testAppHttp()
    {
        $request = $this->createRequest('GET', 'http://localhost/index');
        $response = $this->handleRequest($request);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertStringContainsString('Do you not know that a man is not dead while his name is still spoken?', (string) $response->getBody());
    }
}
