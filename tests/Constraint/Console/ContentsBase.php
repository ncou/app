<?php

declare(strict_types=1);

namespace Tests\Constraint\Console;

use PHPUnit\Framework\Constraint\Constraint;

/**
 * Base constraint for content constraints
 *
 * @internal
 */
abstract class ContentsBase extends Constraint
{
    /**
     * @var string
     */
    protected string $contents;

    /**
     * @var string
     */
    protected string $output;

    /**
     * Constructor
     *
     * @param array<string> $contents Contents
     * @param string $output Output type
     */
    public function __construct(array $contents, string $output)
    {
        $this->contents = implode(PHP_EOL, $contents);
        $this->output = $output;
    }
}
