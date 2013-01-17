<?php

namespace Gnugat\SoulMeMaybe;

use Symfony\Component\Console\Application as BaseApplication,
    Symfony\Component\Console\Input\ArrayInput,
    Symfony\Component\Console\Input\InputDefinition,
    Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Output\OutputInterface,
    Symfony\Component\Console\Formatter\OutputFormatterStyle,
    Symfony\Component\Console\Formatter\OutputFormatter,
    Symfony\Component\Console\Output\ConsoleOutput;

use Gnugat\SoulMeMaybe\Client\Command as ClientCommand,
    Gnugat\SoulMeMaybe\Configurator\Command as ConfiguratorCommand,
    Gnugat\SoulMeMaybe\Help\Command as HelpCommand;

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

        $name = $this->getCommandName($input);
        if (NULL === $name) {
            $name = 'help';
            $input = new ArrayInput(array('command' => 'help'));
        }

        if (function_exists('posix_isatty') && $this->getHelperSet()->has('dialog')) {
            $inputStream = $this->getHelperSet()->get('dialog')->getInputStream();
            if (!posix_isatty($inputStream)) {
                $input->setInteractive(false);
            }
        }

        // the command name MUST be the first element of the input.
        $command = $this->find($name);

        $this->runningCommand = $command;
        $statusCode = $command->run($input, $output);
        $this->runningCommand = null;

        return is_numeric($statusCode) ? $statusCode : 0;
    }

    /**
     * {@inheritDoc}
     */
    protected function getDefaultInputDefinition()
    {
        return new InputDefinition(array(
            new InputArgument('command', InputArgument::REQUIRED, 'The command to execute'),
        ));
    }

    /**
     * {@inheritDoc}
     */
    protected function getDefaultCommands()
    {
        $commands = array(
            new ClientCommand(),
            new ConfiguratorCommand(),
            new HelpCommand(),
        );

        return $commands;
    }

    /**
     * {@inheritDoc}
     */
    public function getHelp()
    {
        $help = <<< EOF
%s

<comment>Usage:</comment>
  app/console [command]
EOF;

        return sprintf($help, $this->getLongVersion());
    }
}
