<?php

declare(strict_types=1);

namespace Tests;

use Chiron\Boot\Directories;
use Chiron\Application;
use Chiron\Http\Http;
use Chiron\Filesystem\Filesystem;
use Nyholm\Psr7\ServerRequest;
use Psr\Http\Message\ServerRequestInterface;

class ConsoleTest extends TestCase
{
    public function testAppConsole()
    {
        $output = $this->runCommand('about');

        $this->assertStringContainsString('Framework', $output);
    }
}
