<?php

declare(strict_types=1);

namespace Tests\Constraint\Response;

/**
 * BodyContains
 *
 * @internal
 */
class BodyNotContains extends BodyContains
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
        return 'is not in response body';
    }
}
