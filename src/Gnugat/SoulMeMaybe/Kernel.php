<?php

namespace Gnugat\SoulMeMaybe;

/**
 * Kernel class.
 *
 * @author Loic Chardonnet <loic.chardonnet@gmail.com>
 */
class Kernel
{
    const HOST = '10.42.1.59';
    const PORT = 4242;

    /**
     * Connects to the NetSoul server.
     *
     * @throws \Exception
     */
    public function connect()
    {
        $filePointer = fsockopen(self::HOST, self::PORT);

        if (false === $filePointer) {
            throw new \Exception("Error: Could not connect to the NetSoul server\n");
        }
    }
}
