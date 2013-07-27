<?php

/*
 * This file is part of the SoulMeMaybe software.
 *
 * (c) Loïc Chardonnet <loic.chardonnet@gmail.com>
 *
 * For the full copyright and license information, please view the `/LICENSE.md`
 * file that was distributed with this source code.
 */

namespace Gnugat\Tests\NetSoul\Commands;

use Exception;

use Gnugat\NetSoul\Commands\AuthenticationAgreement;
use Gnugat\NetSoul\RawCommand;

use PHPUnit_Framework_TestCase;

use Symfony\Component\Yaml\Yaml;

class CommandTest extends PHPUnit_Framework_TestCase
{
    private function getFixtures()
    {
        $fixtures = Yaml::parse(__DIR__.'/../../Fixtures/commands.yml');

        return $fixtures['commands'];
    }

    public function testSuccessfulConstructionFromRawMessage()
    {
        $fixtures = $this->getFixtures();

        foreach ($fixtures as $commandName => $fixture) {
            $rawCommand = RawCommand::makeFromString($fixture['raw'].PHP_EOL);
            $namespacedCommandName = 'Gnugat\\NetSoul\\Commands\\'.$commandName;
            $command = $namespacedCommandName::makeFromRawCommand($rawCommand);

            foreach ($fixture['parameters'] as $name => $parameter) {
                $getter = 'get'.ucfirst($name);

                $this->assertSame($parameter, $command->$getter());
            }
        }
    }

    public function testWrongCommandName()
    {
        $fixtures = $this->getFixtures();

        foreach ($fixtures as $commandName => $fixture) {
            $rawCommand = RawCommand::makeFromString($fixture['raw'].PHP_EOL);
            $namespacedCommandName = 'Gnugat\\NetSoul\\Commands\\'.$commandName;

            $parameters = array('wrong_command');
            for ($numberOfParameters = 0; $numberOfParameters !== $namespacedCommandName::NUMBER_OF_PARAMETERS; $numberOfParameters++) {
                $parameters[] = 'parameter';
            }

            $rawCommand = RawCommand::makeFromString(implode(' ', $parameters).PHP_EOL);

            $hasRaisedException = false;
            try {
                $namespacedCommandName::makeFromRawCommand($rawCommand);
            } catch (Exception $e) {
                $hasRaisedException = true;
            }

            $this->assertTrue($hasRaisedException);
        }
    }

    public function testFailureOnWrongNumberOfParameters()
    {
        $fixtures = $this->getFixtures();

        foreach ($fixtures as $commandName => $fixture) {
            $rawCommand = RawCommand::makeFromString($fixture['raw'].PHP_EOL);
            $namespacedCommandName = 'Gnugat\\NetSoul\\Commands\\'.$commandName;

            $parameters = array($fixture['name']);
            for ($numberOfParameters = 0; $numberOfParameters < $namespacedCommandName::NUMBER_OF_PARAMETERS; $numberOfParameters++) {
                $rawCommand = RawCommand::makeFromString(implode(' ', $parameters).PHP_EOL);

                $hasRaisedException = false;
                try {
                    $namespacedCommandName::makeFromRawCommand($rawCommand);
                } catch (Exception $e) {
                    $hasRaisedException = true;
                }

                $this->assertTrue($hasRaisedException);
                $parameters[] = 'parameter';
            }
        }
    }

    public function testFailureTooManyParameters()
    {
        $fixtures = $this->getFixtures();
        unset($fixtures['Response']);

        foreach ($fixtures as $commandName => $fixture) {
            $rawCommand = RawCommand::makeFromString($fixture['raw'].PHP_EOL);
            $namespacedCommandName = 'Gnugat\\NetSoul\\Commands\\'.$commandName;

            $parameters = array('wrong_command');
            $tooManyParameters = $namespacedCommandName::NUMBER_OF_PARAMETERS + 1;
            for ($numberOfParameters = 0; $numberOfParameters !== $tooManyParameters; $numberOfParameters++) {
                $parameters[] = 'parameter';
            }

            $rawCommand = RawCommand::makeFromString(implode(' ', $parameters).PHP_EOL);

            $hasRaisedException = false;
            try {
                $namespacedCommandName::makeFromRawCommand($rawCommand);
            } catch (Exception $e) {
                $hasRaisedException = true;
            }

            $this->assertTrue($hasRaisedException);
        }
    }
}
