<?php

declare(strict_types=1);

namespace Tests\Constraint\Response;

/**
 * BodyRegExp
 *
 * @internal
 */
class BodyRegExp extends ResponseBase
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
        return preg_match($other, $this->_getBodyAsString()) > 0;
    }

    /**
     * Assertion message
     *
     * @return string
     */
    public function toString(): string
    {
        return 'PCRE pattern found in response body';
    }

    /**
     * @param mixed $other Expected
     * @return string
     */
    public function failureDescription(mixed $other): string
    {
        return '`' . $other . '`' . ' ' . $this->toString();
    }
}
