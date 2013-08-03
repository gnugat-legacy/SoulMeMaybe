<?php

/*
 * This file is part of the SoulMeMaybe software.
 *
 * (c) Loïc Chardonnet <loic.chardonnet@gmail.com>
 *
 * For the full copyright and license information, please view the `/LICENSE.md`
 * file that was distributed with this source code.
 */

namespace Gnugat\SoulMeMaybe\Client;

use Fab\Fab;

use Gnugat\SoulMeMaybe\Client\Kernel;
use Gnugat\SoulMeMaybe\Output;

use Igorw\Fab\FabOutputFormatterStyle;

use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;

use Symfony\Component\Console\Command\Command as BaseCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Formatter\OutputFormatter;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\Yaml\Yaml;

/**
 * Calls the `Client\Kernel` methods in the order defined by the NetSoul
 * protocol, in order to grant the user access to internet inside the
 * University.
 */
class Command extends BaseCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('client')
            ->setDescription('Connects to the NetSoul server')
            ->addOption('--help', '-h', InputOption::VALUE_NONE, 'displays this help')
            ->addOption('--quiet', '-q', InputOption::VALUE_NONE, 'displays only important messages')
            ->addOption('--verbose', '-v', InputOption::VALUE_NONE, 'displays every messages')
            ->addOption('--location', '-l', InputOption::VALUE_REQUIRED, 'sets your location')
            ->addOption('--rainbow', '-r', InputOption::VALUE_NONE, 'makes your console fabulous')
            ->setHelp(<<<EOF
The <info>%command.name%</info> command opens a connection with the NetSoul
server, authenticates the user and keeps the internet connection alive
by pinging the server every 5 minutes.

You can manage the verbosity level with the quiet and verbose options.

<info>%command.full_name% [-q|--quiet]</info>
<info>%command.full_name% [-v|--verbose]</info>

If you want to specify your location (and temporarily overwrite the one
specified in the <comment>app/config/parameters.yml</comment> file), use the
following option (convention: '<in PIE> <room> <line> <station>'):

<info>%command.full_name% [-l|--location=] "Villejuif 302 1 2"</info>

You can make your console fabulous using the rainbow mode:

<info>%command.full_name% [-r|--rainbow]</info>
EOF
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($input->getOption('rainbow')) {
            $output->setFormatter(new OutputFormatter(true, array(
                'fabulous' => new FabOutputFormatterStyle(new Fab()),
            )));
        }

        $dependencies = $this->getDependencies($input, $output);

        if ($input->hasOption('location')) {
            $dependencies['parameters']['user_location'] = $input->getOption('location');
        }

        $kernel = new Kernel($dependencies['parameters'], $dependencies['output']);
        $kernel->connect();
        $kernel->authenticate();
        $kernel->state();
        while (true) {
            sleep(5);

            $kernel->ping();
        }
    }

    /**
     * Gets the dependencies as an array associating name to instances.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return array
     */
    private function getDependencies(InputInterface $input, OutputInterface $output)
    {
        $rootPath = __DIR__.'/../../../..';

        $errorHandler = new RotatingFileHandler($rootPath.'/app/logs/errors.txt', 42, Logger::ERROR);
        $networkHandler = new RotatingFileHandler($rootPath.'/app/logs/network.txt', 42, Logger::DEBUG);

        $logger = new Logger('client');
        $logger->pushHandler($errorHandler);
        $logger->pushHandler($networkHandler);

        $verbosityLevel = OutputInterface::VERBOSITY_NORMAL;
        if (true === $input->getOption('quiet')) {
            $verbosityLevel = OutputInterface::VERBOSITY_QUIET;
        }
        if (true === $input->getOption('verbose')) {
            $verbosityLevel = OutputInterface::VERBOSITY_VERBOSE;
        }

        $output = new Output($logger, $output);
        $output->setVerbosityLevel($verbosityLevel);

        $parameters = Yaml::parse($rootPath.'/app/config/parameters.yml');

        return array(
            'output' => $output,
            'parameters' => $parameters['parameters'],
        );
    }
}
