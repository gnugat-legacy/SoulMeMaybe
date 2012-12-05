<?php

namespace Gnugat\SoulMeMaybe\Command;

use Symfony\Component\Console\Command\Command,
    Symfony\Component\Console\Input\InputOption,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Output\OutputInterface;

use Gnugat\SoulMeMaybe\Kernel;

/**
 * Connect command class.
 *
 * @author Loic Chardonnet <loic.chardonnet@gmail.com>
 */
class ConnectCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('connect')
            ->setDescription('Connects to the NetSoul server')
            ->addOption('--help', '-h', InputOption::VALUE_NONE, 'displays this help')
            ->setHelp(<<<EOF
The <info>%command.name%</info> command opens a connection to the NetSoul server,
authenticates the user and keep the internet connection alive
by pinging the server every 5 minutes.

<info>php %command.full_name% [-h|--help]</info>
EOF
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $kernel = new Kernel(__DIR__.'/../../../../config/parameters.yml');
            $kernel->connect();
            $kernel->authenticate();
            $kernel->state();
            while (true) {
                sleep(5);

                $kernel->ping();
            }
        } catch (\Exception $exception) {
            die($exception->getMessage());
        }
    }
}
