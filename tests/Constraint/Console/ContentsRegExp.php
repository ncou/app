<?php

declare(strict_types=1);

namespace Tests\Constraint\Console;

/**
 * ContentsRegExp
 *
 * @internal
 */
class ContentsRegExp extends ContentsBase
{
    /**
     * Checks if contents contain expected
     *
     * @param mixed $other Expected
     * @return bool
     */
    public function matches(mixed $other): bool
    {
        return preg_match($other, $this->contents) > 0;
    }

    /**
     * Assertion message
     *
     * @return string
     */
    public function toString(): string
    {
        return sprintf('PCRE pattern found in %s', $this->output);
    }

    /**
     * @param mixed $other Expected
     * @return string
     */
    public function failureDescription(mixed $other): string
    {
        return '`' . $other . '` ' . $this->toString();
    }
}
