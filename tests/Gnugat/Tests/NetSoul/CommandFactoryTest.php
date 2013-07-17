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

use Gnugat\NetSoul\CommandFactory;
use Gnugat\NetSoul\Commands;
use Gnugat\NetSoul\RawCommand;

use PHPUnit_Framework_TestCase;

class CommandFactoryTest extends PHPUnit_Framework_TestCase
{
    private function getFixture($commandName)
    {
        $fixtureFile = __DIR__.'/../Fixtures/Commands/'.$commandName.'.txt';
        $rawCommand = file_get_contents($fixtureFile);

        return RawCommand::makeFromString($rawCommand);
    }

    public function testSupportedCommands()
    {
        $factory = new CommandFactory();
        foreach ($factory->getSupportedCommands() as $supportedCommand) {
            $sourceFile = __DIR__.'/../../../../src/Gnugat/NetSoul/Commands/'.$supportedCommand.'.php';
            $testFile = __DIR__.'/Commands/'.$supportedCommand.'Test.php';

            $this->assertFileExists($sourceFile);
            $this->assertFileExists($testFile);
        }
    }

    public function testSuccessfulMake()
    {
        $factory = new CommandFactory();
        foreach ($factory->getSupportedCommands() as $supportedCommand) {
            $namespacedClass = 'Gnugat\\NetSoul\\Commands\\'.$supportedCommand;
            $rawCommand = $this->getFixture($supportedCommand);

            $this->assertTrue($factory->make($rawCommand) instanceof $namespacedClass);
        }
    }

    /**
     * @expectedException Exception
     */
    public function testMakeFailure()
    {
        $factory = new CommandFactory();
        $rawCommand = RawCommand::makeFromString('fake command'.PHP_EOL);

        $factory->make($rawCommand);
    }
}
