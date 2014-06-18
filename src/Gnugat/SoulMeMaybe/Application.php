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

use Gnugat\SoulMeMaybe\Client\Command as ClientCommand;
use Gnugat\SoulMeMaybe\Configurator\Command as ConfiguratorCommand;
use Gnugat\SoulMeMaybe\Help\Command as HelpCommand;
use Gnugat\SoulMeMaybe\VersionExtractor;

use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Container of the available commands, providing a standard CLI environment.
 */
class Application extends BaseApplication
{
    /**
     * @const NAME The application's name.
     */
    const NAME = 'SoulMeMaybe';

    /**
     * @param VersionExtractor
     */
    private $versionExtractor;

    /**
     * @param VersionExtractor $versionExtractor
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
    public function doRun(InputInterface $input, OutputInterface $output)
    {
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
     * @return VersionExtractor
     */
    public function getVersionExtractor()
    {
        return $this->versionExtractor;
    }

    /**
     * Catches the interruption signals and exits the program cleanly by
     * calling the destructors.
     */
    private function manageUnixSignals()
    {
        declare(ticks = 1);

        pcntl_signal(SIGINT, 'exit');
        pcntl_signal(SIGTERM, 'exit');
    }
}
