<?php

/*
 * This file is part of the SoulMeMaybe software.
 *
 * (c) Loïc Chardonnet <loic.chardonnet@gmail.com>
 *
 * For the full copyright and license information, please view the `/LICENSE.md`
 * file that was distributed with this source code.
 */

namespace Gnugat\SoulMeMaybe\Configurator;

use Gnugat\SoulMeMaybe\Configurator\Kernel;

use Symfony\Component\Console\Command\Command as BaseCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Asks the user his login and password and passes them to the
 * `Configurator\Kernel`.
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
