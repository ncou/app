<?php

declare(strict_types=1);

namespace Tests\Constraint\Response;

use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\Constraint\Constraint;
use Psr\Http\Message\ResponseInterface;

/**
 * Base constraint for response constraints
 *
 * @internal
 */
abstract class ResponseBase extends Constraint
{
    /**
     * @var \Psr\Http\Message\ResponseInterface
     */
    protected ResponseInterface $response;

    /**
     * Constructor
     *
     * @param \Psr\Http\Message\ResponseInterface|null $response Response
     */
    public function __construct(?ResponseInterface $response)
    {
        if (!$response) {
            throw new AssertionFailedError('No response set, cannot assert content.');
        }

        $this->response = $response;
    }

    /**
     * Get the response body as string
     *
     * @return string The response body.
     */
    protected function _getBodyAsString(): string
    {
        return (string)$this->response->getBody();
    }
}
