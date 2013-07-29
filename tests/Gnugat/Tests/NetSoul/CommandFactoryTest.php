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
use Gnugat\NetSoul\RawCommand;

use PHPUnit_Framework_TestCase;

use Symfony\Component\Yaml\Yaml;

class CommandFactoryTest extends PHPUnit_Framework_TestCase
{
    private function getFixtures()
    {
        $fixtures = array();

        $fixtureFileNames = array(
            __DIR__.'/Commands/fixtures/generics.yml',
            __DIR__.'/Commands/fixtures/unlimited_parameters.yml',
        );
        foreach ($fixtureFileNames as $fixtureFileName) {
            $fixtureFile = file_get_contents($fixtureFileName);
            $fixture = Yaml::parse($fixtureFile);

            $fixtures = array_merge($fixtures, $fixture['commands']);
        }

        return $fixtures;
    }

    public function testSupportedCommands()
    {
        $factory = new CommandFactory();
        foreach ($factory->getSupportedCommands() as $supportedCommand) {
            $sourceFile = __DIR__.'/../../../../src/Gnugat/NetSoul/Commands/'.$supportedCommand.'.php';

            $this->assertFileExists($sourceFile);
        }
    }

    public function testSuccessfulMake()
    {
        $fixtures = $this->getFixtures();

        $factory = new CommandFactory();
        foreach ($factory->getSupportedCommands() as $supportedCommand) {
            $namespacedClass = 'Gnugat\\NetSoul\\Commands\\'.$supportedCommand;
            $rawCommand = RawCommand::makeFromString($fixtures[$supportedCommand]['raw'].PHP_EOL);

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
