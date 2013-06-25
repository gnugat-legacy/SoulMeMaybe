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
 * Test output class.
 *
 * @author Loic Chardonnet <loic.chardonnet@gmail.com>
 */
class TestOutput extends Output
{
    /** @var string The last message. */
    public $lastMessage;

    /**
     * {@inheritdoc}
     */
    protected function doWrite($message, $newline)
    {
        $this->lastMessage = $message;
    }
}
