<?php

declare(strict_types=1);

namespace Tests\Constraint\Response;

/**
 * StatusCode
 *
 * @internal
 */
class StatusCode extends StatusCodeBase
{
    /**
     * Assertion message
     *
     * @return string
     */
    public function toString(): string
    {
        return sprintf('matches response status code `%d`', $this->response->getStatusCode());
    }

    /**
     * Failure description
     *
     * @param mixed $other Expected code
     * @return string
     */
    public function failureDescription(mixed $other): string
    {
        return '`' . $other . '` ' . $this->toString();
    }
}
