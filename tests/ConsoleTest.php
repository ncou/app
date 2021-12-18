<?php

declare(strict_types=1);

namespace Tests;

use Tests\Traits\InteractsWithConsoleTrait;

class ConsoleTest extends AbstractTestCase
{
    use InteractsWithConsoleTrait;

    public function testAppConsole()
    {
        $output = $this->runCommand('about');

        $this->assertStringContainsString('Framework', $output);
    }
}
