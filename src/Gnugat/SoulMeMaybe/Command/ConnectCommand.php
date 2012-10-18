<?php

namespace Gnugat\SoulMeMaybe\Command;

use Symfony\Component\Console\Command\Command,
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
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $kernel = new Kernel(__DIR__.'/../../../../config/parameters.yml');
            $kernel->connect();
            $kernel->authenticate();
            while (true) {
                sleep(5);

                $kernel->ping();
            }
        } catch (\Exception $exception) {
            die($exception->getMessage());
        }
    }
}
