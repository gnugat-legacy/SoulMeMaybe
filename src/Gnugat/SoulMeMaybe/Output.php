<?php

/*
 * This file is part of the SoulMeMaybe software.
 *
 * (c) Loïc Chardonnet <loic.chardonnet@gmail.com>
 *
 * For the full copyright and license information, please view the `/LICENSE.md`
 * file that was distributed with this source code.
 */

namespace Gnugat\SoulMeMaybe;

use Symfony\Component\Console\Output\OutputInterface;

use Monolog\Logger;

/**
 * Logs and writes given messages, according to the verbosity and log levels.
 */
class Output
{
    /**
     * @var Logger
     */
    private $logger;

    /**
     * @var OutputInterface
     */
    private $consoleOutput;

    /**
     * @var array
     */
    private $writePermissions = array();

    /**
     * @var integer
     */
    private $verbosityLevel = OutputInterface::VERBOSITY_NORMAL;

    /**
     * @param Logger          $logger
     * @param OutputInterface $consoleOutput
     */
    public function __construct(Logger $logger, OutputInterface $consoleOutput)
    {
        $this->logger = $logger;
        $this->consoleOutput = $consoleOutput;

        $this->writePermissions = array(
            OutputInterface::VERBOSITY_QUIET => Logger::CRITICAL,
            OutputInterface::VERBOSITY_NORMAL => Logger::INFO,
            OutputInterface::VERBOSITY_VERBOSE => Logger::DEBUG,
        );
    }

    /**
     * @param integer $verbosityLevel
     */
    public function setVerbosityLevel($verbosityLevel)
    {
        $this->verbosityLevel = $verbosityLevel;
    }

    /**
     * Manages the message of the given log level (as defined in Logger).
     * If the output's formatter has the `fabulous` style, adds
     * `<fabulous></fabulous>` decoration tags to the message.
     *
     * @param string  $message
     * @param integer $logLevel
     */
    public function manageMessageOfGivenLogLevel($message, $logLevel)
    {
        $hasToBeWritten = $this->writePermissions[$this->verbosityLevel] <= $logLevel;

        $isFabulous = false;
        $formatter = $this->consoleOutput->getFormatter();
        if ($formatter) {
            $isFabulous = $formatter->hasStyle('fabulous');
        }

        $this->logger->addRecord($logLevel, $message);
        if ($hasToBeWritten === true) {
            $this->consoleOutput->writeln(sprintf(
                '%s%s%s',
                $isFabulous ? '<fabulous>' : '',
                $message,
                $isFabulous ? '</fabulous>' : ''
            ));
        }
    }
}
