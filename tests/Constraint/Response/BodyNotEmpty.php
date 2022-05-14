<?php

declare(strict_types=1);

namespace Tests\Constraint\Response;

/**
 * BodyNotEmpty
 *
 * @internal
 */
class BodyNotEmpty extends BodyEmpty
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
        return 'response body is not empty';
    }
}
