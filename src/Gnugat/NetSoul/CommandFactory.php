<?php

/*
 * This file is part of the SoulMeMaybe software.
 *
 * (c) Loïc Chardonnet <loic.chardonnet@gmail.com>
 *
 * For the full copyright and license information, please view the `/LICENSE.md`
 * file that was distributed with this source code.
 */

namespace Gnugat\NetSoul;

use Gnugat\NetSoul\Commands;

class CommandFactory
{
    const NEW_CONNECTION = 'salut';

    /**
     * @param string $commandName The first word of the sent or received string.
     */
    public function make($commandName)
    {
        $namesAndClasses = array(
            self::NEW_CONNECTION => 'NewConnection',
        );

        if (!array_key_exists($commandName, $namesAndClasses)) {
            throw new \Exception('Unknown message name: '.$commandName);
        }

        $class = 'Gnugat\\NetSoul\\Commands\\'.$namesAndClasses[$commandName];

        return new $class();
    }
}
