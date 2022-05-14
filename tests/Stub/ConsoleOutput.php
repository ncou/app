<?php

namespace Tests\Stub;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\ConsoleSectionOutput;
use Symfony\Component\Console\Formatter\OutputFormatterInterface;

class ConsoleOutput extends SpyOutput implements ConsoleOutputInterface
{
    private SpyOutput $stderr;

    /**
     * @param int                           $verbosity The verbosity level (one of the VERBOSITY constants in OutputInterface)
     * @param bool|null                     $decorated Whether to decorate messages (null for auto-guessing)
     * @param OutputFormatterInterface|null $formatter Output formatter instance (null to use default OutputFormatter)
     */
    public function __construct(int $verbosity = self::VERBOSITY_NORMAL, bool $decorated = null, OutputFormatterInterface $formatter = null)
    {
        // TODO : attention on force le decorated à false je ne sais pas si c'est logique de faire ca !!!!
        parent::__construct($verbosity, false, $formatter);
        $this->stderr = new SpyOutput($verbosity, false, $formatter);
    }

    /**
     * {@inheritdoc}
     */
    public function getErrorOutput()
    {
        return $this->stderr;
    }

    /**
     * {@inheritdoc}
     */
    public function setErrorOutput(OutputInterface $error)
    {
        $this->stderr = $error;
    }

    /**
     * Creates a new output section.
     */
    public function section(): ConsoleSectionOutput
    {
        throw new \LogicException(sprintf('Method "%s" not implemented in this stub.', __FUNCTION__));

    }
}
