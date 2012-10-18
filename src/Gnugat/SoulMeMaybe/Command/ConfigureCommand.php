<?php

namespace Gnugat\SoulMeMaybe\Command;

use Symfony\Component\Console\Command\Command,
    Symfony\Component\Console\Input\InputOption,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Output\OutputInterface;

use Gnugat\SoulMeMaybe\Configurator;

/**
 * Configure command class.
 *
 * @author Loic Chardonnet <loic.chardonnet@gmail.com>
 */
class ConfigureCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('configure')
            ->setDescription('Configures the login and the password socks')
            ->addOption('--help', '-h', InputOption::VALUE_NONE, 'displays this help')
            ->setHelp(<<<EOF
The <info>%command.name%</info> command asks the login and password socks to
configure SoulMeMaybe.

<info>php %command.full_name% [-h|--help]</info>
EOF
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $configurator = new Configurator();
        $configurator->getUserLoginFromCli();
        $configurator->getPasswordSocksFromCli();
        $configurator->writeParametersFile();
    }
}
