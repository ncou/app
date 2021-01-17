<?php

declare(strict_types=1);

namespace Tests;

class HttpTest extends AbstractTestCase
{
    public function testAppHttp()
    {
        $request = $this->request('GET', '/app/public/index'); // TODO : récupérer le base_path !!!!!

        $response = $this->http->handle($request);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertStringContainsString('Do you not know that a man is not dead while his name is still spoken?', (string) $response->getBody());
    }
}
