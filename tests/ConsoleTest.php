<?php

declare(strict_types=1);

namespace Tests;

class ConsoleTest extends AbstractTestCase
{
    public function testAppConsole(): void
    {
        $this->runCommand('route:list');
        // Assert return result is successfull.
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
        // Assert return result is a failure.
        $this->assertExitFailure();
        $this->assertErrorContains('Command "non_existing_command" is not defined.');
    }
}
