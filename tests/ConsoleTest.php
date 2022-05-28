<?php

declare(strict_types=1);

namespace Tests;

class ConsoleTest extends AbstractTestCase
{
    public function testAppConsole(): void
    {
        $this->runCommand('route:list');

        $this->assertExitSuccess();
        $this->assertOutputContainsRow([
            'Method:',
            'Path:',
            'Handler:',
        ]);
        $this->assertOutputContainsRow([
            'GET',
            '/',
            'Callback()',
        ]);
    }

    public function testAppConsoleError(): void
    {
        $this->runCommand('non_existing_command');

        $this->assertExitFailure();
        $this->assertErrorContains('Command "non_existing_command" is not defined.');
    }
}
