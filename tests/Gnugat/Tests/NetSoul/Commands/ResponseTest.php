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

use Gnugat\NetSoul\Commands\Response;
use Gnugat\NetSoul\RawCommand;

use PHPUnit_Framework_TestCase;

use Exception;

class ResponseTest extends PHPUnit_Framework_TestCase
{
    public function testSuccessfulConstructionFromRawMessage()
    {
        $parameters = array(
            'code' => '002',
            'separator' => '--',
            'message' => 'cmd end',
        );
        $fixture = Response::NAME.' '.implode(' ', $parameters).PHP_EOL;

        $rawCommand = RawCommand::makeFromString($fixture);
        $response = Response::makeFromRawCommand($rawCommand);

        foreach ($parameters as $name => $parameter) {
            $getter = 'get'.ucfirst($name);

            $this->assertSame($parameter, $response->$getter());
        }
    }

    /**
     * @expectedException Exception
     */
    public function testWrongCommandName()
    {
        $parameters = array('wrong_command');
        for ($numberOfParameters = 0; $numberOfParameters !== Response::NUMBER_OF_PARAMETERS; $numberOfParameters++) {
            $parameters[] = 'parameter';
        }

        $rawCommand = RawCommand::makeFromString(implode(' ', $parameters).PHP_EOL);

        Response::makeFromRawCommand($rawCommand);
    }

    public function testFailureOnWrongNumberOfParameters()
    {
        $parameters = array(Response::NAME);
        for ($numberOfParameters = 0; $numberOfParameters < Response::NUMBER_OF_PARAMETERS; $numberOfParameters++) {
            $rawCommand = RawCommand::makeFromString(implode(' ', $parameters).PHP_EOL);

            $hasRaisedException = false;
            try {
                Response::makeFromRawCommand($rawCommand);
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
    public function testFailureOnWrongSeparator()
    {
        $parameters = array(
            'code' => '002',
            'separator' => 'invalid-separator',
            'message' => 'cmd end',
        );
        $fixture = Response::NAME.' '.implode(' ', $parameters).PHP_EOL;

        $rawCommand = RawCommand::makeFromString($fixture);

        Response::makeFromRawCommand($rawCommand);
    }
}
