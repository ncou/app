<?php

declare(strict_types=1);

namespace Tests;

use Tests\Traits\InteractsWithHttpTrait;

class HttpTest extends AbstractTestCase
{
    use InteractsWithHttpTrait;

    /**
     * @dataProvider dataProvider
     */
    public function testAppHttp(string $language, string $locale, string $quote)
    {
        $this->runRequest('GET', 'http://localhost/', ['Accept-Language' => $language]); // TODO : il faudrait surement directement un uri '/' plutot que 'http://localhost/' et pour éviter une erreur lors du control du middleware AllowedHostsMiddleware il faut mettre le booléen du debug à true !!!!

        $this->assertResponseOk();
        $this->assertHeader('X-Clacks-Overhead', 'GNU Terry Pratchett');
        $this->assertContentType('text/html');
        $this->assertResponseContains(sprintf('<html lang="%s">', $locale));
        $this->assertResponseContains($quote);
    }

    public function dataProvider(): array
    {
        return [
            ['', 'en', 'A man is not dead while his name is still spoken.'],
            ['en', 'en', 'A man is not dead while his name is still spoken.'],
            ['de', 'en', 'A man is not dead while his name is still spoken.'],
            ['fr', 'fr', 'Un homme n\'est pas mort tant que son nom est encore prononcé.'],
            ['fr;q=0.9', 'fr', 'Un homme n\'est pas mort tant que son nom est encore prononcé.'],
            ['de;q=0.7, fr;q=0.9, *;q=0.5', 'fr', 'Un homme n\'est pas mort tant que son nom est encore prononcé.'],
        ];
    }


    /**
     * Test that missing template renders 404 page in production
     *
     * @return void
     */
    /*
    public function testMissingTemplate()
    {
        Configure::write('debug', false);
        $this->get('/pages/not_existing');

        $this->assertResponseError();
        $this->assertResponseContains('Error');
    }*/

    /**
     * Test that missing template in debug mode renders missing_template error page
     *
     * @return void
     */
    /*
    public function testMissingTemplateInDebug()
    {
        Configure::write('debug', true);
        $this->get('/pages/not_existing');

        $this->assertResponseFailure();
        $this->assertResponseContains('Missing Template');
        $this->assertResponseContains('Stacktrace');
        $this->assertResponseContains('not_existing.php');
    }*/

    /**
     * Test directory traversal protection
     *
     * @return void
     */
    /*
    public function testDirectoryTraversalProtection()
    {
        $this->get('/pages/../Layout/ajax');
        $this->assertResponseCode(403);
        $this->assertResponseContains('Forbidden');
    }*/
}
