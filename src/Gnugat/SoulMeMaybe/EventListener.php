<?php

namespace Gnugat\SoulMeMaybe;

/**
 * EventListener class.
 *
 * @author Loic Chardonnet <loic.chardonnet@gmail.com>
 */
class EventListener
{
    /**
     * Post install event.
     */
    public static function postInstall()
    {
        $configurator = new Configurator();
        $configurator->getUserLoginFromCli();
        $configurator->getPasswordSocksFromCli();
        $configurator->writeParametersFile();
    }
}