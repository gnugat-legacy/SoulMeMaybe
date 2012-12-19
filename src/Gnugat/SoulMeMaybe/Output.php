<?php

namespace Gnugat\SoulMeMaybe;

use Symfony\Component\Console\Output\OutputInterface;

use Monolog\Logger;

/**
 * Output class.
 *
 * Logs and writes given messages, according to the verbosity and log levels.
 *
 * @author Loic Chardonnet <loic.chardonnet@gmail.com>
 */
class Output
{
    /** @var \Monolog\Logger The logger. */
    private $logger;

    /** @var \Symfony\Component\Console\Output\OutputInterface The console output. */
    private $consoleOutput;

    /** @var array The write permissions. */
    private $writePermissions = array();

    /** @var integer The verbosity level, as defined in \Symfony\Component\Console\Output\OutputInterface. */
    private $verbosityLevel = OutputInterface::VERBOSITY_NORMAL;

    /**
     * The constructor.
     *
     * @param \Monolog\Logger                                   $logger        The logger.
     * @param \Symfony\Component\Console\Output\OutputInterface $consoleOutput The console output.
     */
    public function __construct(Logger $logger, OutputInterface $consoleOutput)
    {
        $this->logger = $logger;
        $this->consoleOutput = $consoleOutput;

        $this->writePermissions = array(
            OutputInterface::VERBOSITY_QUIET => array(
                Logger::DEBUG => false,
                Logger::INFO => false,
                Logger::NOTICE => false,
                Logger::WARNING => false,
                Logger::ERROR => false,
                Logger::CRITICAL => true,
                Logger::ALERT => true,
                Logger::EMERGENCY => true,
            ),
            OutputInterface::VERBOSITY_NORMAL => array(
                Logger::DEBUG => false,
                Logger::INFO => true,
                Logger::NOTICE => true,
                Logger::WARNING => true,
                Logger::ERROR => true,
                Logger::CRITICAL => true,
                Logger::ALERT => true,
                Logger::EMERGENCY => true,
            ),
            OutputInterface::VERBOSITY_VERBOSE => array(
                Logger::DEBUG => true,
                Logger::INFO => true,
                Logger::NOTICE => true,
                Logger::WARNING => true,
                Logger::ERROR => true,
                Logger::CRITICAL => true,
                Logger::ALERT => true,
                Logger::EMERGENCY => true,
            ),
        );
    }

    /**
     * Sets the verbosity level.
     *
     * @param integer $verbosityLevel The verbosity level.
     */
    public function setVerbosityLevel($verbosityLevel)
    {
        $this->verbosityLevel = $verbosityLevel;
    }

    /**
     * Manages the message of the given log level.
     *
     * @param string  $message  The message.
     * @param integer $logLevel The log level as defined in \Monolog\Logger.
     */
    public function manageMessageOfGivenLogLevel($message, $logLevel)
    {
        $hasToBeWritten = $this->writePermissions[$this->verbosityLevel][$logLevel];

        $this->logger->addRecord($logLevel, $message);
        if ($hasToBeWritten === true) {
            $this->consoleOutput->writeln($message);
        }
    }
}
