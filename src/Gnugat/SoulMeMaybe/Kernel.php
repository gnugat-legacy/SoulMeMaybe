<?php

namespace Gnugat\SoulMeMaybe;

/**
 * Kernel class.
 *
 * @author Loic Chardonnet <loic.chardonnet@gmail.com>
 */
class Kernel
{
    public static $HOST = '10.42.1.59';
    public static $PORT = 4242;

    public function connect()
    {
        $filePointer = fsockopen(self::$HOST, self::$PORT);

        if (false === $filePointer) {
            throw new \Exception("Error: Could not connect to the NetSoul server\n");
        }
    }
}
