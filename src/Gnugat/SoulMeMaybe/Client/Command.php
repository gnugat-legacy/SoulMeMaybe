<?php

namespace Gnugat\SoulMeMaybe\Client;

use Symfony\Component\Console\Command\Command as BaseCommand,
    Symfony\Component\Console\Input\InputOption,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Output\OutputInterface,
    Symfony\Component\Yaml\Yaml;

use Monolog\Logger,
    Monolog\Handler\RotatingFileHandler;

use Gnugat\SoulMeMaybe\Output,
    Gnugat\SoulMeMaybe\Client\Kernel;

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
            ->setName('client')
            ->setDescription('Connects to the NetSoul server')
            ->addOption('--help', '-h', InputOption::VALUE_NONE, 'displays this help')
            ->addOption('--quiet', '-q', InputOption::VALUE_NONE, 'displays only important messages')
            ->addOption('--verbose', '-v', InputOption::VALUE_NONE, 'displays every messages')
            ->addOption('--rainbow', '-r', InputOption::VALUE_NONE, 'switches the state to draw a rainbow')
            ->setHelp(<<<EOF
The <info>%command.name%</info> command opens a connection to the NetSoul server,
authenticates the user and keeps the internet connection alive
by pinging the server every 5 minutes.

You can manage the verbosity level with the quiet and verbose options:

<info>%command.full_name% [-q|--quiet] [-v|--verbose]</info>

You can make other clients draw rainbow by switching your state automatically:

<info>%command.full_name% [-r|--rainbow]</info>
EOF
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dependencies = $this->getDependencies($input, $output);

        $kernel = new Kernel($dependencies['parameters'], $dependencies['output']);
        $kernel->connect();
        $kernel->authenticate();
        $kernel->state();
        while (true) {
            if (true === $input->getOption('rainbow')) {
                $kernel->rainbow();
            }
            sleep(5);

            $kernel->ping();
        }
    }

    /**
     * Gets the dependencies.
     *
     * @param \Symfony\Component\Console\Input\InputInterface   $input  The input.
     * @param \Symfony\Component\Console\Output\OutputInterface $output The output.
     *
     * @return array The dependencies with their names associated to their values.
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
