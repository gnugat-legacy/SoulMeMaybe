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
    /** @var \Symfony\Component\Console\Command\Command The command. */
    private $command = null;

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
     * Sets the command
     *
     * @param \Symfony\Component\Console\Command\Command $command The command to set.
     */
    public function setCommand(BaseCommand $command)
    {
        $this->command = $command;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (null === $this->command) {
            $this->command = $this->getApplication();
        }

        $output->writeln($this->command->asText());

        $this->command = null;
    }
}
