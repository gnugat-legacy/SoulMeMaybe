<?php

namespace Gnugat\SoulMeMaybe\Command;

use Symfony\Component\Console\Command\Command,
    Symfony\Component\Console\Input\InputOption,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Output\OutputInterface;

use Monolog\Logger,
    Monolog\Handler\RotatingFileHandler;

use Gnugat\SoulMeMaybe\Kernel;

/**
 * Connect command class.
 *
 * @author Loic Chardonnet <loic.chardonnet@gmail.com>
 */
class ConnectCommand extends Command
{
    /**
     * @see Command
     */
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
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $rootPath = __DIR__.'/../../../..';

        $errorHandler = new RotatingFileHandler($rootPath.'/logs/errors.txt', 42);

        $logger = new Logger('connect');
        $logger->pushHandler($errorHandler);

        $parameters = Yaml::parse($rootPath.'/config/parameters.yml');

        try {
            $kernel = new Kernel($parameters, $logger);
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
