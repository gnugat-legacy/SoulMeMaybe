<?php

/*
 * This file is part of the SoulMeMaybe software.
 *
 * (c) Loïc Chardonnet <loic.chardonnet@gmail.com>
 *
 * For the full copyright and license information, please view the `/LICENSE.md`
 * file that was distributed with this source code.
 */

namespace Gnugat\Tests\SoulMeMaybe;

use Gnugat\SoulMeMaybe\Output;
use Gnugat\Tests\Fixtures\TestOutput;

use Monolog\Handler\NullHandler;
use Monolog\Handler\TestHandler;
use Monolog\Logger;

use PHPUnit_Framework_TestCase;

use Symfony\Component\Console\Output\OutputInterface;

class OutputTest extends PHPUnit_Framework_TestCase
{
    public function testLog()
    {
        $logLevels = array(
            'Debug' => Logger::DEBUG,
            'Info' => Logger::INFO,
            'Notice' => Logger::NOTICE,
            'Warning' => Logger::WARNING,
            'Error' => Logger::ERROR,
            'Critical' => Logger::CRITICAL,
            'Alert' => Logger::ALERT,
            'Emergency' => Logger::EMERGENCY,
        );

        foreach ($logLevels as $handlerLogLevel) {
            $handler = new TestHandler($handlerLogLevel);

            $logger = new Logger('test');
            $logger->pushHandler($handler);

            $console = $this->getMockBuilder('Symfony\Component\Console\Output\OutputInterface')
                ->disableOriginalConstructor()
                ->getMock();

            $output = new Output($logger, $console);

            foreach ($logLevels as $logLevelName => $logLevelValue) {
                $record = uniqid();
                $output->manageMessageOfGivenLogLevel($record, $logLevelValue);

                $hasRecord = false;
                if ($handlerLogLevel <= $logLevelValue) {
                    $hasRecord = true;
                }

                $methodName = 'has'.$logLevelName.'Records';
                $this->assertSame($hasRecord, $handler->{$methodName}($record));
            }
        }
    }

    public function testConsoleOutput()
    {
        $logLevels = array(
            Logger::DEBUG,
            Logger::INFO,
            Logger::NOTICE,
            Logger::WARNING,
            Logger::ERROR,
            Logger::CRITICAL,
            Logger::ALERT,
            Logger::EMERGENCY,
        );

        $writePermissions = array(
            OutputInterface::VERBOSITY_QUIET => Logger::CRITICAL,
            OutputInterface::VERBOSITY_NORMAL => Logger::INFO,
            OutputInterface::VERBOSITY_VERBOSE => Logger::DEBUG,
        );

        foreach ($writePermissions as $verbosityLevel => $minimumLogLevel) {
            foreach ($logLevels as $logLevel) {
                $handler = new NullHandler();

                $logger = new Logger('test');
                $logger->pushHandler($handler);

                $message = uniqid();

                $formatter = $this->getMockBuilder('Symfony\Component\Console\Formatter\OutputFormatter')
                    ->disableOriginalConstructor()
                    ->getMock();

                $formatter->expects($this->any())
                    ->method('format')
                    ->will($this->returnValue($message));

                $consoleOutput = new TestOutput(OutputInterface::VERBOSITY_NORMAL, false, $formatter);

                $output = new Output($logger, $consoleOutput);
                $output->setVerbosityLevel($verbosityLevel);

                $output->manageMessageOfGivenLogLevel($message, $logLevel);

                $hasMessageBeenWritten = false;
                if ($message === $consoleOutput->lastMessage) {
                    $hasMessageBeenWritten = true;
                }

                $shouldMessageBeWritten = false;
                if ($minimumLogLevel <= $logLevel) {
                    $shouldMessageBeWritten = true;
                }

                $this->assertSame($shouldMessageBeWritten, $hasMessageBeenWritten);
            }
        }
    }
}
