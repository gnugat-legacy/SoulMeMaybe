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

class NewConnection
{
    const NAME = 'salut';
    const NUMBER_OF_PARAMETERS = 5;

    /**
     * @var string
     */
    private $socketNumber;

    /**
     * @var string
     */
    private $hashSeed;

    /**
     * @var string
     */
    private $clientHost;

    /**
     * @var string
     */
    private $clientPort;

    /**
     * @var string
     */
    private $connectionTimestamp;

    /**
     * @param string $rawCommand
     *
     * @return NewConnection
     */
    public static function makeFromRawCommand($rawCommand)
    {
        $rawCommand = trim($rawCommand);
        $parameters = explode(' ', $rawCommand);
        array_shift($parameters);
        $numberOfParameters = count($parameters);
        if ($numberOfParameters !== self::NUMBER_OF_PARAMETERS) {
            throw new Exception(sprintf(
                'Error: given %s parameters, expected %s',
                $numberOfParameters,
                self::NUMBER_OF_PARAMETERS
            ));
        }

        $newConnection = new NewConnection();

        $newConnection->socketNumber = $parameters[0];
        $newConnection->hashSeed = $parameters[1];
        $newConnection->clientHost = $parameters[2];
        $newConnection->clientPort = $parameters[3];
        $newConnection->connectionTimestamp = $parameters[4];

        return $newConnection;
    }

    /**
     * @return string
     */
    public function getSocketNumber()
    {
        return $this->socketNumber;
    }

    /**
     * @return string
     */
    public function getHashSeed()
    {
        return $this->hashSeed;
    }

    /**
     * @return string
     */
    public function getClientPort()
    {
        return $this->clientPort;
    }

    /**
     * @return string
     */
    public function getClientHost()
    {
        return $this->clientHost;
    }

    /**
     * @return string
     */
    public function getConnectionTimestamp()
    {
        return $this->connectionTimestamp;
    }
}
