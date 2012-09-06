<?php

namespace Gnugat\SoulMeMaybe;

use Symfony\Component\Yaml\Yaml;

/**
 * Kernel class.
 *
 * @author Loic Chardonnet <loic.chardonnet@gmail.com>
 */
class Kernel
{
    /**
     * @var array The parameters.
     */
    private $parameters;

    /**
     * The constructor.
     *
     * @param string $parametersFilePath The parameters file path.
     */
    public function __construct($parametersFilePath)
    {
        $this->parameters = Yaml::parse($parametersFilePath)['parameters'];
    }

    /**
     * Connects to the NetSoul server.
     *
     * @throws \Exception
     */
    public function connect()
    {
        $filePointer = fsockopen($this->parameters['host'], $this->parameters['port']);

        if (false === $filePointer) {
            throw new \Exception("Error: Could not connect to the NetSoul server\n");
        }
    }
}
