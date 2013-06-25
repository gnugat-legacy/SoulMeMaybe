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

use Gnugat\SoulMeMaybe\VersionExtractor;

/**
 * Application class.
 *
 * @author Loic Chardonnet <loic.chardonnet@gmail.com>
 */
class Application extends BaseApplication
{
    /** @const The application's name. */
    const NAME = 'SoulMeMaybe';

    /**
     * @param \Gnugat\SoulMeMaybe\VersionExtractor
     */
    private $versionExtractor;

    /**
     * @param \Gnugat\SoulMeMaybe\VersionExtractor $versionExtractor
     */
    public function __construct(VersionExtractor $versionExtractor)
    {
        $this->manageUnixSignals();

        $this->versionExtractor = $versionExtractor;
        $version = $versionExtractor->getVersionNumber();

        parent::__construct(self::NAME, $version);
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

        $hasHelpOption = $input->hasParameterOption(array('--help', '-h'));

        $name = $this->getCommandName($input);
        $originalName = $name;
        if (null === $name || true === $hasHelpOption) {
            $name = 'help';
            $input = new ArrayInput(array('command' => 'help'));
        }

        if (function_exists('posix_isatty') && $this->getHelperSet()->has('dialog')) {
            $inputStream = $this->getHelperSet()->get('dialog')->getInputStream();
            if (!posix_isatty($inputStream)) {
                $input->setInteractive(false);
            }
        }

        // The command name MUST be the first element of the input.
        $command = $this->find($name);
        if (true === $hasHelpOption) {
            if (null === $originalName || 'help' === $originalName) {
                throw new \RuntimeException('The "-h" or "--help" option does not exist.');
            }
            $originalCommand = $this->find($originalName);
            $command->setCommand($originalCommand);
        }

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
        return <<< EOF
{$this->getLongVersion()}

<comment>Usage:</comment>
  {$_SERVER['PHP_SELF']} [command]
EOF;
    }

    /**
     * @return Gnugat\SoulMeMaybe\VersionExtractor
     */
    public function getVersionExtractor()
    {
        return $this->versionExtractor;
    }

    private function manageUnixSignals()
    {
        declare(ticks = 1);

        $cleanExit = function() {
            exit;
        };
        pcntl_signal(SIGINT, $cleanExit);
        pcntl_signal(SIGTERM, $cleanExit);
    }
}
