<?php

declare(strict_types=1);

namespace Tests\Constraint\Response;

/**
 * Constraint for ensuring a header does not contain a value.
 *
 * @internal
 */
class HeaderNotContains extends HeaderContains
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
        return sprintf(
            "is not in header '%s' (`%s`)",
            $this->headerName,
            $this->response->getHeaderLine($this->headerName)
        );
    }
}
