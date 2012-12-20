<?php

namespace Gnugat\SoulMeMaybe;

use Symfony\Component\Console\Application as BaseApplication,
    Symfony\Component\Console\Input\InputDefinition,
    Symfony\Component\Console\Input\InputOption,
    Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Output\OutputInterface,
    Symfony\Component\Console\Formatter\OutputFormatterStyle,
    Symfony\Component\Console\Formatter\OutputFormatter,
    Symfony\Component\Console\Output\ConsoleOutput;

use Gnugat\SoulMeMaybe\Client\Command as ClientCommand,
    Gnugat\SoulMeMaybe\Configurator\Command as ConfiguratorCommand;

/**
 * Application class.
 *
 * @author Loic Chardonnet <loic.chardonnet@gmail.com>
 */
class Application extends BaseApplication
{
    /** @const The application's name. */
    const NAME = 'SoulMeMaybe';

    /** @const The application' name's version. */
    const VERSION = '2.0.0';

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct(self::NAME, self::VERSION);
    }

    /**
     * {@inheritDoc}
     */
    public function run(InputInterface $input = null, OutputInterface $output = null)
    {
        if (null === $output) {
            $styles['highlight'] = new OutputFormatterStyle('red');
            $styles['warning'] = new OutputFormatterStyle('black', 'yellow');
            $formatter = new OutputFormatter(null, $styles);
            $output = new ConsoleOutput(ConsoleOutput::VERBOSITY_NORMAL, null, $formatter);
        }

        return parent::run($input, $output);
    }

    /**
     * {@inheritDoc}
     */
    public function doRun(InputInterface $input, OutputInterface $output)
    {
        if (true === version_compare(PHP_VERSION, '5.3.3', '<')) {
            $output->writeln(
                '<warning>'.self::NAME.' only officially supports PHP 5.3.3 and above, you will most likely encounter'
                .' problems with your PHP '.PHP_VERSION.', upgrading is strongly recommended.</warning>'
            );
        }

        return parent::doRun($input, $output);
    }

    /**
     * {@inheritDoc}
     */
    protected function getDefaultInputDefinition()
    {
        return new InputDefinition(array(
            new InputArgument('command', InputArgument::REQUIRED, 'The command to execute'),

            new InputOption('--help', '-h', InputOption::VALUE_NONE, 'Display this help message.'),
            new InputOption('--version', '-V', InputOption::VALUE_NONE, 'Display this application version.'),
        ));
    }

    /**
     * {@inheritDoc}
     */
    protected function getDefaultCommands()
    {
        $commands = parent::getDefaultCommands();
        $commands[] = new ClientCommand();
        $commands[] = new ConfiguratorCommand();

        return $commands;
    }
}
