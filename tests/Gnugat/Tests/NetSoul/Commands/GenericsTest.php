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

use Gnugat\NetSoul\RawCommand;

use Symfony\Component\Yaml\Yaml;

/**
 * Generic tests have a limited number of parameters.
 */
class GenericTest extends CommandTestCase
{
    /**
     * {@inheritDoc}
     */
    protected function getFixtures()
    {
        $fixturesFile = file_get_contents(__DIR__.'/fixtures/generics.yml');
        $fixtures = Yaml::parse($fixturesFile);

        return $fixtures['commands'];
    }

    public function testFailureTooManyParameters()
    {
        $fixtures = $this->getFixtures();

        foreach ($fixtures as $commandName => $fixture) {
            $rawCommand = RawCommand::makeFromString($fixture['raw'].PHP_EOL);
            $namespacedCommandName = 'Gnugat\\NetSoul\\Commands\\'.$commandName;

            $tooManyParameters = $namespacedCommandName::NUMBER_OF_PARAMETERS + 1;
            $numberOfPaddedParameters = $tooManyParameters + 2;
            $parameters = array_pad(array('wrong_command_name'), $numberOfPaddedParameters, 'parameter');

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
