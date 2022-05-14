<?php

declare(strict_types=1);

namespace Tests\Constraint\Console;

/**
 * ContentsEmpty
 *
 * @internal
 */
class ContentsEmpty extends ContentsBase
{
    /**
     * Checks if contents are empty
     *
     * @param mixed $other Expected
     * @return bool
     */
    public function matches(mixed $other): bool
    {
        return $this->contents === '';
    }

    /**
     * Assertion message
     *
     * @return string
     */
    public function toString(): string
    {
        return sprintf('%s is empty', $this->output);
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
