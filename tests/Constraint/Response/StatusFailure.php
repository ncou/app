<?php

declare(strict_types=1);

namespace Tests\Constraint\Response;

/**
 * StatusFailure
 *
 * @internal
 */
class StatusFailure extends StatusCodeBase
{
    /**
     * @var array<int, int>|int
     */
    protected array|int $code = [500, 505];

    /**
     * Assertion message
     *
     * @return string
     */
    public function toString(): string
    {
        return sprintf('%d is between 500 and 505', $this->response->getStatusCode());
    }
}
