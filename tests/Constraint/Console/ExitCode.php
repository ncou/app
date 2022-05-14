<?php

declare(strict_types=1);

namespace Tests\Constraint\Console;

use PHPUnit\Framework\Constraint\Constraint;

/**
 * ExitCode constraint
 *
 * @internal
 */
// TODO : attention je ne pense pas qu'on puisse avoir un exitCode qui est null, faire le test lorsqu'il y a une exception mais je ne pense pas que un retunr code à null soit possible !!!
class ExitCode extends Constraint
{
    /**
     * @var int|null
     */
    private ?int $exitCode = null;

    /**
     * Constructor
     *
     * @param int|null $exitCode Exit code
     */
    public function __construct(?int $exitCode)
    {
        $this->exitCode = $exitCode;
    }

    /**
     * Checks if event is in fired array
     *
     * @param mixed $other Constraint check
     * @return bool
     */
    public function matches(mixed $other): bool
    {
        return $other === $this->exitCode;
    }

    /**
     * Assertion message string
     *
     * @return string
     */
    public function toString(): string
    {
        return sprintf('matches exit code %s', $this->exitCode ?? 'null');
    }
}
