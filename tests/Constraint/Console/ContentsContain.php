<?php

declare(strict_types=1);

namespace Tests\Constraint\Console;

/**
 * ContentsContain
 *
 * @internal
 */
class ContentsContain extends ContentsBase
{
    /**
     * Checks if contents contain expected
     *
     * @param mixed $other Expected
     * @return bool
     */
    public function matches(mixed $other): bool
    {
        return mb_strpos($this->contents, $other) !== false;
    }

    /**
     * Assertion message
     *
     * @return string
     */
    public function toString(): string
    {
        return sprintf('is in %s,' . PHP_EOL . 'actual result:' . PHP_EOL, $this->output) . $this->contents;
    }
}
