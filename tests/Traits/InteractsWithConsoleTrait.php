<?php

declare(strict_types=1);

namespace Tests\Traits;

use Chiron\Console\Console;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;

trait InteractsWithConsoleTrait
{
    protected function runCommandDebug(string $command, array $args = [], ?OutputInterface $output = null): string
    {
        $output = $output ?? new BufferedOutput();
        $output->setVerbosity(BufferedOutput::VERBOSITY_VERBOSE);

        return $this->runCommand($command, $args, $output);
    }

    protected function runCommandVeryVerbose(string $command, array $args = [], ?OutputInterface $output = null): string
    {
        $output = $output ?? new BufferedOutput();
        $output->setVerbosity(BufferedOutput::VERBOSITY_DEBUG);

        return $this->runCommand($command, $args, $output);
    }

    protected function runCommand(string $command, array $args = [], ?OutputInterface $output = null): string
    {
        array_unshift($args, $command);

        $input = new ArrayInput($args);
        $output = $output ?? new BufferedOutput();

        $this->console()->run($input, $output);

        return $output->fetch();
    }

    protected function console(): Console
    {
        return $this->app->get(Console::class);
    }
}
