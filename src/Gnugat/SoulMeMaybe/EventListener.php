<?php

/*
 * This file is part of the SoulMeMaybe software.
 *
 * (c) Loïc Chardonnet <loic.chardonnet@gmail.com>
 *
 * For the full copyright and license information, please view the `/LICENSE.md`
 * file that was distributed with this source code.
 */

namespace Gnugat\SoulMeMaybe;

use Gnugat\SoulMeMaybe\Configurator\Kernel as Configurator;
use Gnugat\SoulMeMaybe\VersionExtractor;

use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Formatter\OutputFormatter;
use Symfony\Component\Console\Helper\DialogHelper;
use Symfony\Component\Console\Output\ConsoleOutput;

/**
 * Composer's scripts, called before/after installation/update.
 */
class EventListener
{
    /**
     * Creation of the configuration file.
     */
    public static function postInstall()
    {
        $styles['highlight'] = new OutputFormatterStyle('red');
        $styles['warning'] = new OutputFormatterStyle('black', 'yellow');
        $formatter = new OutputFormatter(null, $styles);
        $output = new ConsoleOutput(ConsoleOutput::VERBOSITY_NORMAL, null, $formatter);

        $configurator = new Configurator(
            $output,
            new DialogHelper(),
            new VersionExtractor(__DIR__.'/../../../VERSION.md')
        );
        $configurator->getUserLoginFromCli();
        $configurator->getPasswordSocksFromCli();
        $configurator->writeParametersFile();
    }

    /**
     * Update of the version in the configuration file.
     */
    public static function postUpdate()
    {
        $styles['highlight'] = new OutputFormatterStyle('red');
        $styles['warning'] = new OutputFormatterStyle('black', 'yellow');
        $formatter = new OutputFormatter(null, $styles);
        $output = new ConsoleOutput(ConsoleOutput::VERBOSITY_NORMAL, null, $formatter);

        $configurator = new Configurator(
            $output,
            new DialogHelper(),
            new VersionExtractor(__DIR__.'/../../../VERSION.md')
        );
        $configurator->updateParametersFile();
    }
}
