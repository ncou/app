<?php

declare(strict_types=1);

namespace Tests\Constraint\Response;

/**
 * HeaderContains
 *
 * @internal
 */
class HeaderContains extends HeaderEquals
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
        return mb_strpos($this->response->getHeaderLine($this->headerName), $other) !== false;
    }

    /**
     * Assertion message
     *
     * @return string
     */
    public function toString(): string
    {
        return sprintf(
            'is in header \'%s\' (`%s`)',
            $this->headerName,
            $this->response->getHeaderLine($this->headerName)
        );
    }
}
