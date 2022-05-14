<?php

declare(strict_types=1);

namespace Tests\Constraint\Response;

/**
 * BodyNotEquals
 *
 * @internal
 */
class BodyNotEquals extends BodyEquals
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
        return parent::matches($other) === false;
    }

    /**
     * Assertion message
     *
     * @return string
     */
    public function toString(): string
    {
        return 'does not match response body';
    }
}
