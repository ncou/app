<?php

declare(strict_types=1);

namespace Tests\Constraint\Response;

/**
 * StatusError
 *
 * @internal
 */
class StatusError extends StatusCodeBase
{
    /**
     * @var array<int, int>|int
     */
    protected array|int $code = [400, 429];

    /**
     * Assertion message
     *
     * @return string
     */
    public function toString(): string
    {
        return sprintf('%d is between 400 and 429', $this->response->getStatusCode());
    }
}
