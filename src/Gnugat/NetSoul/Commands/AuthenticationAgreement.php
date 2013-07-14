<?php

/*
 * This file is part of the SoulMeMaybe software.
 *
 * (c) Loïc Chardonnet <loic.chardonnet@gmail.com>
 *
 * For the full copyright and license information, please view the `/LICENSE.md`
 * file that was distributed with this source code.
 */

namespace Gnugat\NetSoul\Commands;

use Exception;

use Gnugat\NetSoul\RawCommand;

class AuthenticationAgreement
{
    const NAME = 'auth_ag';
    const NUMBER_OF_PARAMETERS = 3;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $firstUnusedParameter;

    /**
     * @var string
     */
    private $secondUnusedParameter;

    /**
     * @param RawCommand $rawCommand
     *
     * @return NewConnection
     *
     * @throws Exception If wrong name of command given.
     * @throws Exception If wrong number of parameters given.
     */
    public static function makeFromRawCommand(RawCommand $rawCommand)
    {
        $name = $rawCommand->getName();
        if (self::NAME !== $name) {
            throw new Exception(sprintf(
                'Wrong command name: %s given, expected %s',
                $name,
                self::NAME
            ));
        }

        $parameters = $rawCommand->getParameters();
        $numberOfParameters = count($parameters);
        if (self::NUMBER_OF_PARAMETERS !== $numberOfParameters) {
            throw new Exception(sprintf(
                'Wrong number of parameters: %s given, expected %s',
                $numberOfParameters,
                self::NUMBER_OF_PARAMETERS
            ));
        }

        $authenticationAgreement = new AuthenticationAgreement();

        $authenticationAgreement->type = $parameters[0];
        $authenticationAgreement->firstUnusedParameter = $parameters[1];
        $authenticationAgreement->secondUnusedParameter = $parameters[2];

        return $authenticationAgreement;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getFirstUnusedParameter()
    {
        return $this->firstUnusedParameter;
    }

    /**
     * @return string
     */
    public function getSecondUnusedParameter()
    {
        return $this->secondUnusedParameter;
    }
}
