<?php

namespace Gnugat\SoulMeMaybe\Configurator;

use Symfony\Component\Console\Command\Command as BaseCommand,
    Symfony\Component\Console\Input\InputOption,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Output\OutputInterface;

use Gnugat\SoulMeMaybe\Configurator\Kernel;

/**
 * Command class.
 *
 * @author Loic Chardonnet <loic.chardonnet@gmail.com>
 */
class Command extends BaseCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('configurator')
            ->setDescription('Configures the login and the password socks')
            ->addOption('--help', '-h', InputOption::VALUE_NONE, 'displays this help')
            ->setHelp(<<<EOF
The <info>%command.name%</info> command asks the login and password socks to
configure SoulMeMaybe.

<info>%command.full_name%</info>
EOF
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $configurator = new Kernel(
            $output,
            $this->getHelper('dialog'),
            $this->getApplication()->getVersionExtractor()
        );
        $configurator->getUserLoginFromCli();
        $configurator->getPasswordSocksFromCli();
        $configurator->writeParametersFile();
    }
}
