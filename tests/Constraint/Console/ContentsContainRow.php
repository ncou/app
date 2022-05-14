<?php

declare(strict_types=1);

namespace Tests\Constraint\Console;

/**
 * ContentsContainRow
 *
 * @internal
 */
class ContentsContainRow extends ContentsRegExp
{
    /**
     * Checks if contents contain expected
     *
     * @param mixed $other Row
     * @return bool
     */
    public function matches(mixed $other): bool
    {
        $row = array_map(function ($cell) {
            return preg_quote($cell, '/');
        }, (array)$other);
        $cells = implode('\s+\|\s+', $row);
        $pattern = '/' . $cells . '/';

        return preg_match($pattern, $this->contents) > 0;
    }

    /**
     * Assertion message
     *
     * @return string
     */
    public function toString(): string
    {
        return sprintf('row was in %s', $this->output);
    }

    /**
     * @param mixed $other Expected content
     * @return string
     */
    public function failureDescription(mixed $other): string
    {
        return '`' . $this->exporter()->shortenedExport($other) . '` ' . $this->toString();
    }
}
