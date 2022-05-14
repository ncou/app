<?php

declare(strict_types=1);

namespace Tests\Constraint\Response;

/**
 * StatusCodeBase
 *
 * @internal
 */
abstract class StatusCodeBase extends ResponseBase
{
    /**
     * @var array<int, int>|int
     */
    protected array|int $code;

    /**
     * Check assertion
     *
     * @param array<int, int>|int $other Array of min/max status codes, or a single code
     * @return bool
     * @psalm-suppress MoreSpecificImplementedParamType
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingNativeTypeHint
     */
    public function matches($other): bool
    {
        if (!$other) {
            $other = $this->code;
        }

        if (is_array($other)) {
            return $this->statusCodeBetween($other[0], $other[1]);
        }

        return $this->response->getStatusCode() === $other;
    }

    /**
     * Helper for checking status codes
     *
     * @param int $min Min status code (inclusive)
     * @param int $max Max status code (inclusive)
     * @return bool
     */
    protected function statusCodeBetween(int $min, int $max): bool
    {
        return $this->response->getStatusCode() >= $min && $this->response->getStatusCode() <= $max;
    }

    /**
     * Overwrites the descriptions so we can remove the automatic "expected" message
     *
     * @param mixed $other Value
     * @return string
     */
    protected function failureDescription(mixed $other): string
    {
        /** @psalm-suppress InternalMethod */
        return $this->toString();
    }
}
