<?php

declare(strict_types=1);

namespace Tests\Constraint\Console;

/**
 * ContentsNotContain
 *
 * @internal
 */
class ContentsNotContain extends ContentsBase
{
    /**
     * Checks if contents contain expected
     *
     * @param mixed $other Expected
     * @return bool
     */
    public function matches(mixed $other): bool
    {
        return mb_strpos($this->contents, $other) === false;
    }

    /**
     * Assertion message
     *
     * @return string
     */
    public function toString(): string
    {
        return sprintf('is not in %s', $this->output);
    }
}
