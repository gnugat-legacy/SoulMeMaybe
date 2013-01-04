<?php

namespace Gnugat\SoulMeMaybe\Help;

use Symfony\Component\Console\Command\Command as BaseCommand,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Output\OutputInterface;

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
            ->setName('help')
            ->setDescription('Displays this help message');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln($this->getApplication()->asText());
    }
}
