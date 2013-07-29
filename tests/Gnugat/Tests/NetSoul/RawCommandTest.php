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

use Symfony\Component\Yaml\Yaml;

class RawCommandTest extends PHPUnit_Framework_TestCase
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

    public function testName()
    {
        foreach ($this->getFixtures() as $commandClassName => $fixture) {
            $namespacedCommandClassName = 'Gnugat\\NetSoul\\Commands\\'.$commandClassName;
            $rawCommand = RawCommand::makeFromString($fixture['raw'].PHP_EOL);

            $this->assertSame($rawCommand->getName(), $namespacedCommandClassName::NAME);
        }
    }

    public function testParameters()
    {
        foreach ($this->getFixtures() as $fixture) {
            $rawCommand = RawCommand::makeFromString($fixture['raw'].PHP_EOL);
            $parameters = $rawCommand->getParameters();

            $numberOfParameters = count($parameters);

            if ('rep' === $fixture['name']) {
                $parameters[$numberOfParameters - 2] .= ' '.$parameters[$numberOfParameters - 1];
                unset($parameters[$numberOfParameters - 1]);
                $numberOfParameters--;
            }

            $this->assertCount($numberOfParameters, $fixture['parameters']);

            for ($parameterIndex = 0; $parameterIndex < $numberOfParameters; $parameterIndex++) {
                $this->assertSame($parameters[$parameterIndex], array_shift($fixture['parameters']));
            }
        }
    }

    /**
     * @expectedException Exception
     */
    public function testMissingEndOfLine()
    {
        $rawCommand = RawCommand::makeFromString('command without line ending');
    }

    /**
     * @expectedException Exception
     */
    public function testEmptyString()
    {
        $rawCommand = RawCommand::makeFromString(''.PHP_EOL);
    }
}
