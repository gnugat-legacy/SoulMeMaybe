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
 * Implementations of this interface should define a NAME and a
 * NUMBER_OF_PARAMETERS constants.
 *
 * If the command has any parameters, the implementation should also define
 * them as attributes with getters for them.
 */
interface Command
{
    /**
     * Takes the parameters of the raw command and sets them as class
     * attributes.
     * Also checks the command name and the number of parameters.
     *
     * @param RawCommand $rawCommand
     *
     * @return Command
     *
     * @throws Exception If wrong name of command given.
     * @throws Exception If wrong number of parameters given.
     */
    public static function makeFromRawCommand(RawCommand $rawCommand);
}
