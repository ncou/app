<?php

declare(strict_types=1);

namespace Tests;

use Tests\Traits\InteractsWithConsoleTrait;

class ConsoleTest extends AbstractTestCase
{
    use InteractsWithConsoleTrait;

    public function testAppConsole()
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

    public function testAppConsoleError()
    {
        $this->runCommand('non_existing_command');
        // Assert return result is a failure.
        $this->assertExitFailure();
        $this->assertErrorContains('Command "non_existing_command" is not defined.');
    }
}
