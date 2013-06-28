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

use Symfony\Component\Console\Output\Output;

/**
 * A wrapping of the Output class, making the last message available.
 */
class TestOutput extends Output
{
    /**
     * @var string
     */
    public $lastMessage;

    /**
     * {@inheritdoc}
     */
    protected function doWrite($message, $newline)
    {
        $this->lastMessage = $message;
    }
}
