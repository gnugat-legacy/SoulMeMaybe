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
 * Commands with unlimited parameters have a separator.
 */
class UnlimitedParametersTest extends CommandTestCase
{
    /**
     * {@inheritDoc}
     */
    protected function getFixtures()
    {
        $fixturesFile = file_get_contents(__DIR__.'/fixtures/unlimited_parameters.yml');
        $fixtures = Yaml::parse($fixturesFile);

        return $fixtures['commands'];
    }

    public function testFailureOnWrongSeparator()
    {
        $fixtures = $this->getFixtures();

        foreach ($fixtures as $commandName => $fixture) {
            $namespacedCommandName = 'Gnugat\\NetSoul\\Commands\\'.$commandName;

            $numberOfPaddedParameters = $namespacedCommandName::NUMBER_OF_PARAMETERS + 2;
            $parameters = array_pad(array($namespacedCommandName::NAME), $numberOfPaddedParameters, 'parameter');
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
