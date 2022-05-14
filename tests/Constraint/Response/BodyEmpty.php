<?php

declare(strict_types=1);

namespace Tests\Constraint\Response;

/**
 * BodyEmpty
 *
 * @internal
 */
class BodyEmpty extends ResponseBase
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
        return empty($this->_getBodyAsString());
    }

    /**
     * Assertion message
     *
     * @return string
     */
    public function toString(): string
    {
        return 'response body is empty';
    }

    /**
     * Overwrites the descriptions so we can remove the automatic "expected" message
     *
     * @param mixed $other Value
     * @return string
     */
    protected function failureDescription(mixed $other): string
    {
        return $this->toString();
    }
}
