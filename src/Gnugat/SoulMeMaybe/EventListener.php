<?php

namespace Gnugat\SoulMeMaybe;

use Gnugat\SoulMeMaybe\Configurator\Kernel as Configurator;

use Symfony\Component\Console\Formatter\OutputFormatterStyle,
    Symfony\Component\Console\Formatter\OutputFormatter,
    Symfony\Component\Console\Output\ConsoleOutput,
    Symfony\Component\Console\Helper\DialogHelper;

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
        $styles['highlight'] = new OutputFormatterStyle('red');
        $styles['warning'] = new OutputFormatterStyle('black', 'yellow');
        $formatter = new OutputFormatter(null, $styles);
        $output = new ConsoleOutput(ConsoleOutput::VERBOSITY_NORMAL, null, $formatter);

        $configurator = new Configurator($output, new DialogHelper());
        $configurator->getUserLoginFromCli();
        $configurator->getPasswordSocksFromCli();
        $configurator->writeParametersFile();
    }
}
