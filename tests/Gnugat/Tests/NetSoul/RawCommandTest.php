<?php

/*
 * This file is part of the SoulMeMaybe software.
 *
 * (c) Loïc Chardonnet <loic.chardonnet@gmail.com>
 *
 * For the full copyright and license information, please view the `/LICENSE.md`
 * file that was distributed with this source code.
 */

namespace Gnugat\Tests\NetSoul;

use Exception;

use Gnugat\NetSoul\RawCommand;

use PHPUnit_Framework_TestCase;

class RawCommandTest extends PHPUnit_Framework_TestCase
{
    private function getFixture($commandName)
    {
        $fixtureFile = __DIR__.'/../Fixtures/Commands/'.$commandName.'.txt';

        return file_get_contents($fixtureFile);
    }

    public function testName()
    {
        $supportedCommands = array(
            'NewConnection',
        );
        foreach ($supportedCommands as $supportedCommand) {
            $namespacedClass = 'Gnugat\\NetSoul\\Commands\\'.$supportedCommand;
            $fixture = $this->getFixture($supportedCommand);
            $rawCommand = new RawCommand($fixture);

            $this->assertSame($rawCommand->getName(), $namespacedClass::NAME);
        }
    }

    public function testParameters()
    {
        $supportedCommands = array(
            'NewConnection',
        );
        foreach ($supportedCommands as $supportedCommand) {
            $namespacedClass = 'Gnugat\\NetSoul\\Commands\\'.$supportedCommand;
            $fixture = $this->getFixture($supportedCommand);
            $rawCommand = new RawCommand($fixture);
            $parameters = $rawCommand->getParameters();
            $numberOfParameters = count($parameters);

            $this->assertSame($numberOfParameters, $namespacedClass::NUMBER_OF_PARAMETERS);
        }
    }

    public function testLastParameter()
    {
        $supportedCommands = array(
            'NewConnection',
        );
        foreach ($supportedCommands as $supportedCommand) {
            $namespacedClass = 'Gnugat\\NetSoul\\Commands\\'.$supportedCommand;
            $fixture = $this->getFixture($supportedCommand);
            $rawCommand = new RawCommand($fixture);
            $parameters = $rawCommand->getParameters();
            $lastParameter = array_pop($parameters);

            $this->assertFalse(strpos($lastParameter, PHP_EOL));
        }
    }

    /**
     * @expectedException Exception
     */
    public function testMissingEndOfLine()
    {
        $rawCommand = new RawCommand('command without line ending');
    }

    /**
     * @expectedException Exception
     */
    public function testEmptyString()
    {
        $rawCommand = new RawCommand(''.PHP_EOL);
    }
}
