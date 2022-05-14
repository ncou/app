<?php

declare(strict_types=1);

namespace Tests\Constraint\Response;

/**
 * HeaderSet
 *
 * @internal
 */
class HeaderNotSet extends HeaderSet
{
    /**
     * Checks assertion
     *
     * @param mixed $other Expected content
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
        return sprintf('did not have header `%s`', $this->headerName);
    }
}
