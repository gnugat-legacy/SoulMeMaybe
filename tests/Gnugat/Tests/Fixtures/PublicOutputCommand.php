<?php

/*
 * This file is part of the SoulMeMaybe software.
 *
 * (c) Loïc Chardonnet <loic.chardonnet@gmail.com>
 *
 * For the full copyright and license information, please view the `/LICENSE.md`
 * file that was distributed with this source code.
 */

namespace Gnugat\Tests\Fixtures;

use Symfony\Component\Console\Command\Command,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Output\OutputInterface;

/**
 * Fixture commands publicing its output.
 *
 * @author Loic Chardonnet <loic.chardonnet@gmail.com>
 */
class PublicOutputCommand extends Command
{
    /**
     * @var \Symfony\Component\Console\Output\OutputInterface The output.
     */
    public $output;

    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('fixture:public:input')
            ->setDescription('Publicing the input')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;
    }
}
