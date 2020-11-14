<?php

declare(strict_types=1);

namespace Tests;

class ConsoleTest extends AbstractTestCase
{
    public function testAppConsole()
    {
        $output = $this->runCommand('about');

        $this->assertStringContainsString('Framework', $output);
    }
}
