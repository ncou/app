<?php

declare(strict_types=1);

namespace Tests\Traits;

use Chiron\Http\Http;
use Nyholm\Psr7\ServerRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Tests\Constraint\Response\BodyContains;
use Tests\Constraint\Response\BodyEmpty;
use Tests\Constraint\Response\BodyEquals;
use Tests\Constraint\Response\BodyNotContains;
use Tests\Constraint\Response\BodyNotEmpty;
use Tests\Constraint\Response\BodyNotEquals;
use Tests\Constraint\Response\BodyNotRegExp;
use Tests\Constraint\Response\BodyRegExp;
use Tests\Constraint\Response\ContentType;
use Tests\Constraint\Response\FileSent;
use Tests\Constraint\Response\FileSentAs;
use Tests\Constraint\Response\HeaderContains;
use Tests\Constraint\Response\HeaderEquals;
use Tests\Constraint\Response\HeaderNotContains;
use Tests\Constraint\Response\HeaderNotSet;
use Tests\Constraint\Response\HeaderSet;
use Tests\Constraint\Response\StatusCode;
use Tests\Constraint\Response\StatusError;
use Tests\Constraint\Response\StatusFailure;
use Tests\Constraint\Response\StatusOk;
use Tests\Constraint\Response\StatusSuccess;

//https://github.com/cakephp/cakephp/blob/5.x/src/TestSuite/IntegrationTestTrait.php
//https://github.com/cakephp/cakephp/blob/73fdfea3d5e87b7d32b0a23a119dda7a4f48ad79/tests/TestCase/TestSuite/IntegrationTestTraitTest.php#L1239

// TODO : ajouter un assertHtml ??? https://github.com/cakephp/cakephp/blob/5.x/src/TestSuite/TestCase.php#L644

// TODO : ajouter les assert sur les cookies et cookies encryptés :
//https://github.com/cakephp/cakephp/blob/5.x/src/TestSuite/IntegrationTestTrait.php#L1299
//https://github.com/cakephp/cakephp/blob/5.x/src/Utility/CookieCryptTrait.php
//https://github.com/cakephp/cakephp/blob/5.x/src/TestSuite/Constraint/Response/CookieEquals.php  <= + les autres cnstraint CookieSet/NotSet/EncryptedEquals.

trait InteractsWithHttpTrait
{
    private ResponseInterface $response;
    /**
     * Asserts that the response status code is in the 2xx range.
     *
     * @param string $message Custom message for failure.
     * @return void
     */
    public function assertResponseOk(string $message = ''): void
    {
        $this->assertThat(null, new StatusOk($this->response), $message);
    }

    /**
     * Asserts that the response status code is in the 2xx/3xx range.
     *
     * @param string $message Custom message for failure.
     * @return void
     */
    public function assertResponseSuccess(string $message = ''): void
    {
        $this->assertThat(null, new StatusSuccess($this->response), $message);
    }

    /**
     * Asserts that the response status code is in the 4xx range.
     *
     * @param string $message Custom message for failure.
     * @return void
     */
    public function assertResponseError(string $message = ''): void
    {
        $this->assertThat(null, new StatusError($this->response), $message);
    }

    /**
     * Asserts that the response status code is in the 5xx range.
     *
     * @param string $message Custom message for failure.
     * @return void
     */
    public function assertResponseFailure(string $message = ''): void
    {
        $this->assertThat(null, new StatusFailure($this->response), $message);
    }

    /**
     * Asserts a specific response status code.
     *
     * @param int $code Status code to assert.
     * @param string $message Custom message for failure.
     * @return void
     */
    public function assertResponseCode(int $code, string $message = ''): void
    {
        $this->assertThat($code, new StatusCode($this->response), $message);
    }

    /**
     * Asserts that the Location header is correct. Comparison is made against a full URL.
     *
     * @param array|string|null $url The URL you expected the client to go to. This
     *   can either be a string URL or an array compatible with Router::url(). Use null to
     *   simply check for the existence of this header.
     * @param string $message The failure message that will be appended to the generated message.
     * @return void
     */
    public function assertRedirect(array|string|null $url = null, string $message = ''): void
    {
        if (!$this->response) {
            $this->fail('No response set, cannot assert header.');
        }

        $this->assertThat(null, new HeaderSet($this->response, 'Location'), $message);

        if ($url) {
            $this->assertThat(
                Router::url($url, true),
                new HeaderEquals($this->response, 'Location'),
                $message
            );
        }
    }

    /**
     * Asserts that the Location header is correct. Comparison is made against exactly the URL provided.
     *
     * @param array|string|null $url The URL you expected the client to go to. This
     *   can either be a string URL or an array compatible with Router::url(). Use null to
     *   simply check for the existence of this header.
     * @param string $message The failure message that will be appended to the generated message.
     * @return void
     */
    public function assertRedirectEquals(array|string|null $url = null, string $message = ''): void
    {
        if (!$this->response) {
            $this->fail('No response set, cannot assert header.');
        }

        $this->assertThat(null, new HeaderSet($this->response, 'Location'), $message);

        if ($url) {
            $this->assertThat(Router::url($url), new HeaderEquals($this->response, 'Location'), $message);
        }
    }

    /**
     * Asserts that the Location header contains a substring
     *
     * @param string $url The URL you expected the client to go to.
     * @param string $message The failure message that will be appended to the generated message.
     * @return void
     */
    public function assertRedirectContains(string $url, string $message = ''): void
    {
        if (!$this->response) {
            $this->fail('No response set, cannot assert header.');
        }

        $this->assertThat(null, new HeaderSet($this->response, 'Location'), $message);
        $this->assertThat($url, new HeaderContains($this->response, 'Location'), $message);
    }

    /**
     * Asserts that the Location header does not contain a substring
     *
     * @param string $url The URL you expected the client to go to.
     * @param string $message The failure message that will be appended to the generated message.
     * @return void
     */
    public function assertRedirectNotContains(string $url, string $message = ''): void
    {
        if (!$this->response) {
            $this->fail('No response set, cannot assert header.');
        }

        $this->assertThat(null, new HeaderSet($this->response, 'Location'), $message);
        $this->assertThat($url, new HeaderNotContains($this->response, 'Location'), $message);
    }

    /**
     * Asserts that the Location header is not set.
     *
     * @param string $message The failure message that will be appended to the generated message.
     * @return void
     */
    public function assertNoRedirect(string $message = ''): void
    {
        $this->assertThat(null, new HeaderNotSet($this->response, 'Location'), $message);
    }

    /**
     * Asserts response headers
     *
     * @param string $header The header to check
     * @param string $content The content to check for.
     * @param string $message The failure message that will be appended to the generated message.
     * @return void
     */
    public function assertHeader(string $header, string $content, string $message = ''): void
    {
        if (!$this->response) {
            $this->fail('No response set, cannot assert header.');
        }

        $this->assertThat(null, new HeaderSet($this->response, $header), $message);
        $this->assertThat($content, new HeaderEquals($this->response, $header), $message);
    }

    /**
     * Asserts response header contains a string
     *
     * @param string $header The header to check
     * @param string $content The content to check for.
     * @param string $message The failure message that will be appended to the generated message.
     * @return void
     */
    public function assertHeaderContains(string $header, string $content, string $message = ''): void
    {
        if (!$this->response) {
            $this->fail('No response set, cannot assert header.');
        }

        $this->assertThat(null, new HeaderSet($this->response, $header), $message);
        $this->assertThat($content, new HeaderContains($this->response, $header), $message);
    }

    /**
     * Asserts response header does not contain a string
     *
     * @param string $header The header to check
     * @param string $content The content to check for.
     * @param string $message The failure message that will be appended to the generated message.
     * @return void
     */
    public function assertHeaderNotContains(string $header, string $content, string $message = ''): void
    {
        if (!$this->response) {
            $this->fail('No response set, cannot assert header.');
        }

        $this->assertThat(null, new HeaderSet($this->response, $header), $message);
        $this->assertThat($content, new HeaderNotContains($this->response, $header), $message);
    }

    /**
     * Asserts content type
     *
     * @param string $type The content-type to check for.
     * @param string $message The failure message that will be appended to the generated message.
     * @return void
     */
    public function assertContentType(string $type, string $message = ''): void
    {
        $this->assertThat($type, new ContentType($this->response), $message);
    }

    /**
     * Asserts content in the response body equals.
     *
     * @param mixed $content The content to check for.
     * @param string $message The failure message that will be appended to the generated message.
     * @return void
     */
    public function assertResponseEquals(mixed $content, string $message = ''): void
    {
        $this->assertThat($content, new BodyEquals($this->response), $message);
    }

    /**
     * Asserts content in the response body not equals.
     *
     * @param mixed $content The content to check for.
     * @param string $message The failure message that will be appended to the generated message.
     * @return void
     */
    public function assertResponseNotEquals(mixed $content, string $message = ''): void
    {
        $this->assertThat($content, new BodyNotEquals($this->response), $message);
    }

    /**
     * Asserts content exists in the response body.
     *
     * @param string $content The content to check for.
     * @param string $message The failure message that will be appended to the generated message.
     * @param bool $ignoreCase A flag to check whether we should ignore case or not.
     * @return void
     */
    public function assertResponseContains(string $content, string $message = '', bool $ignoreCase = false): void
    {
        if (!$this->response) {
            $this->fail('No response set, cannot assert content.');
        }

        $this->assertThat($content, new BodyContains($this->response, $ignoreCase), $message);
    }

    /**
     * Asserts content does not exist in the response body.
     *
     * @param string $content The content to check for.
     * @param string $message The failure message that will be appended to the generated message.
     * @param bool $ignoreCase A flag to check whether we should ignore case or not.
     * @return void
     */
    public function assertResponseNotContains(string $content, string $message = '', bool $ignoreCase = false): void
    {
        if (!$this->response) {
            $this->fail('No response set, cannot assert content.');
        }

        $this->assertThat($content, new BodyNotContains($this->response, $ignoreCase), $message);
    }

    /**
     * Asserts that the response body matches a given regular expression.
     *
     * @param string $pattern The pattern to compare against.
     * @param string $message The failure message that will be appended to the generated message.
     * @return void
     */
    public function assertResponseRegExp(string $pattern, string $message = ''): void
    {
        $this->assertThat($pattern, new BodyRegExp($this->response), $message);
    }

    /**
     * Asserts that the response body does not match a given regular expression.
     *
     * @param string $pattern The pattern to compare against.
     * @param string $message The failure message that will be appended to the generated message.
     * @return void
     */
    public function assertResponseNotRegExp(string $pattern, string $message = ''): void
    {
        $this->assertThat($pattern, new BodyNotRegExp($this->response), $message);
    }

    /**
     * Assert response content is not empty.
     *
     * @param string $message The failure message that will be appended to the generated message.
     * @return void
     */
    public function assertResponseNotEmpty(string $message = ''): void
    {
        $this->assertThat(null, new BodyNotEmpty($this->response), $message);
    }

    /**
     * Assert response content is empty.
     *
     * @param string $message The failure message that will be appended to the generated message.
     * @return void
     */
    public function assertResponseEmpty(string $message = ''): void
    {
        $this->assertThat(null, new BodyEmpty($this->response), $message);
    }




    protected function runRequest(string $method, $uri, array $headers = []): void
    {
        // TODO : attacher automatiquement le base_path à l'uri !!!
        // https://github.com/clue/reactphp-buzz/blob/2d4c93be8cba9f482e96b8567916b32c737a9811/src/Message/MessageFactory.php#L120
        $request = new ServerRequest($method, $uri, $headers, null, '1.1', []); // TODO : faire un mock pour le ServerRequestInterface au lieu d'utiliser la librairie de nyholm ???
        $this->response = $this->http()->handle($request);
    }

    protected function http(): Http
    {
        return $this->app->get(Http::class);
    }
}
