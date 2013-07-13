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

use Gnugat\NetSoul\Commands\NewConnection;

use PHPUnit_Framework_TestCase;

use Exception;

class NewConnectionTest extends PHPUnit_Framework_TestCase
{
    public function testSuccessfulConstructionFromRawMessage()
    {
        $parameters = array(
            'name' => NewConnection::NAME,
            'socketNumber' => '27',
            'hashSeed' => '2fb93c1e8020c71ccf99f6555f70e56f',
            'clientHost' => '195.220.50.8',
            'clientPort' => '45686',
            'connectionTimestamp' => '1036068977',
        );

        $rawCommand = implode(' ', $parameters).PHP_EOL;
        $newConnection = NewConnection::makeFromRawCommand($rawCommand);

        // Skipping command name, as there are no getters for it.
        array_shift($parameters);
        foreach ($parameters as $name => $parameter) {
            $getter = 'get'.ucfirst($name);

            $this->assertSame($parameter, $newConnection->$getter());
        }
    }

    public function testFailureOnWrongNumberOfParameters()
    {
        $parameters = array(NewConnection::NAME);
        for ($numberOfParameters = 0; $numberOfParameters < NewConnection::NUMBER_OF_PARAMETERS; $numberOfParameters++) {
            $rawCommand = implode(' ', $parameters).PHP_EOL;

            $hasRaisedException = false;
            try {
                NewConnection::makeFromRawCommand($rawCommand);
            } catch (Exception $e) {
                $hasRaisedException = true;
            }
            $this->assertTrue($hasRaisedException);

            $parameters[] = 'parameter';
        }
    }

    /**
     * @expectedException Exception
     */
    public function testFailureTooManyParameters()
    {
        $parameters = array(NewConnection::NAME);
        for ($numberOfParameters = 0; $numberOfParameters > NewConnection::NUMBER_OF_PARAMETERS; $numberOfParameters++) {
            $parameters[] = 'parameter';
        }

        $rawCommand = implode(' ', $parameters).PHP_EOL;

        $hasRaisedException = false;
        NewConnection::makeFromRawCommand($rawCommand);
    }
}
