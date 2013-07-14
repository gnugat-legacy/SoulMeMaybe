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

use Gnugat\NetSoul\Commands\AuthenticationAgreement;
use Gnugat\NetSoul\RawCommand;

use PHPUnit_Framework_TestCase;

use Exception;

class AuthenticationAgreementTest extends PHPUnit_Framework_TestCase
{
    public function testSuccessfulConstructionFromRawMessage()
    {
        $parameters = array(
            'type' => 'ext_user',
            'firstUnusedParameter' => 'none',
            'secondUnusedParameter' => 'none',
        );
        $fixture = AuthenticationAgreement::NAME.' '.implode(' ', $parameters).PHP_EOL;

        $rawCommand = RawCommand::makeFromString($fixture);
        $authenticationAgreement = AuthenticationAgreement::makeFromRawCommand($rawCommand);

        foreach ($parameters as $name => $parameter) {
            $getter = 'get'.ucfirst($name);

            $this->assertSame($parameter, $authenticationAgreement->$getter());
        }
    }

    /**
     * @expectedException Exception
     */
    public function testWrongCommandName()
    {
        $parameters = array('wrong_command');
        for ($numberOfParameters = 0; $numberOfParameters !== AuthenticationAgreement::NUMBER_OF_PARAMETERS; $numberOfParameters++) {
            $parameters[] = 'parameter';
        }

        $rawCommand = RawCommand::makeFromString(implode(' ', $parameters).PHP_EOL);

        AuthenticationAgreement::makeFromRawCommand($rawCommand);
    }

    public function testFailureOnWrongNumberOfParameters()
    {
        $parameters = array(AuthenticationAgreement::NAME);
        for ($numberOfParameters = 0; $numberOfParameters < AuthenticationAgreement::NUMBER_OF_PARAMETERS; $numberOfParameters++) {
            $rawCommand = RawCommand::makeFromString(implode(' ', $parameters).PHP_EOL);

            $hasRaisedException = false;
            try {
                AuthenticationAgreement::makeFromRawCommand($rawCommand);
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
        $parameters = array(AuthenticationAgreement::NAME);
        $tooManyParameters = AuthenticationAgreement::NUMBER_OF_PARAMETERS + 1;
        for ($numberOfParameters = 0; $numberOfParameters !== $tooManyParameters; $numberOfParameters++) {
            $parameters[] = 'parameter';
        }

        $rawCommand = RawCommand::makeFromString(implode(' ', $parameters).PHP_EOL);

        AuthenticationAgreement::makeFromRawCommand($rawCommand);
    }
}
