<?php

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
