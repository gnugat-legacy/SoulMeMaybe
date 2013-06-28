<?php

/*
 * This file is part of the SoulMeMaybe software.
 *
 * (c) Loïc Chardonnet <loic.chardonnet@gmail.com>
 *
 * For the full copyright and license information, please view the `/LICENSE.md`
 * file that was distributed with this source code.
 */

namespace Gnugat\SoulMeMaybe\Help;

use Symfony\Component\Console\Command\Command as BaseCommand;
use Symfony\Component\Console\Helper\DescriptorHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Displays the description of a command or the application.
 */
class Command extends BaseCommand
{
    /**
     * @var Command
     */
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
     * @param Command $command
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

        $helper = new DescriptorHelper();
        $helper->describe($output, $this->command);

        $this->command = null;
    }
}
