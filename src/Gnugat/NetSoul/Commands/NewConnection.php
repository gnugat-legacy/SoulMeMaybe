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

/**
 * Command sent by the server when a new client connects to it.
 */
class NewConnection implements Command
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
     * {@inheritDoc}
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
