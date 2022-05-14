<?php

declare(strict_types=1);

namespace Tests\Constraint\Response;

/**
 * BodyEquals
 *
 * @internal
 */
class BodyEquals extends ResponseBase
{
    /**
     * Checks assertion
     *
     * @param mixed $other Expected type
     * @return bool
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingNativeTypeHint
     */
    public function matches($other): bool
    {
        return $this->_getBodyAsString() === $other;
    }

    /**
     * Assertion message
     *
     * @return string
     */
    public function toString(): string
    {
        return 'matches response body';
    }
}
