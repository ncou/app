<?php

declare(strict_types=1);

namespace Tests\Constraint\Response;

/**
 * BodyNotRegExp
 *
 * @internal
 */
class BodyNotRegExp extends BodyRegExp
{
    /**
     * Checks assertion
     *
     * @param mixed $other Expected pattern
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
        return 'PCRE pattern not found in response body';
    }
}
