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

use Exception;

use Gnugat\NetSoul\RawCommand;

/**
 * Used when receiving commands.
 */
class CommandFactory
{
    /**
     * @param RawCommand $rawCommand
     *
     * @return Gnugat\NetSoul\Commands\Command
     *
     * @throws Exception If the given command is not supported.
     */
    public function make(RawCommand $rawCommand)
    {
        $commandName = $rawCommand->getName();
        foreach ($this->getSupportedCommands() as $supportedCommand) {
            $class = 'Gnugat\\NetSoul\\Commands\\'.$supportedCommand;
            if ($class::NAME === $commandName) {
                return new $class($rawCommand);
            }
        }

        throw new Exception('Unsupported command: '.$commandName);
    }

    public function getSupportedCommands()
    {
        return array(
            'NewConnection',
            'AuthenticationAgreement',
        );
    }
}
