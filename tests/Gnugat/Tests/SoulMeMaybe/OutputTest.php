<?php

namespace Gnugat\Tests\SoulMeMaybe;

use Gnugat\SoulMeMaybe\Output;

use Symfony\Component\Console\Output\OutputInterface;

use Monolog\Logger,
 Monolog\Handler\TestHandler;

use PHPUnit_Framework_TestCase;

/**
 * Output test class.
 *
 * @author Loic Chardonnet <loic.chardonnet@gmail.com>
 */
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
}
