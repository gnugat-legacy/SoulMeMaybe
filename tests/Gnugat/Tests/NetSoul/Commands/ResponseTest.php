<?php

/*
 * This file is part of the SoulMeMaybe software.
 *
 * (c) Loïc Chardonnet <loic.chardonnet@gmail.com>
 *
 * For the full copyright and license information, please view the `/LICENSE.md`
 * file that was distributed with this source code.
 */

namespace Gnugat\Tests\NetSoul\Commands;

use Gnugat\NetSoul\Commands\Response;
use Gnugat\NetSoul\RawCommand;

use PHPUnit_Framework_TestCase;

use Exception;

class ResponseTest extends PHPUnit_Framework_TestCase
{
    /**
     * @expectedException Exception
     */
    public function testFailureOnWrongSeparator()
    {
        $parameters = array(
            'code' => '002',
            'separator' => 'invalid-separator',
            'message' => 'cmd end',
        );
        $fixture = Response::NAME.' '.implode(' ', $parameters).PHP_EOL;

        $rawCommand = RawCommand::makeFromString($fixture);

        Response::makeFromRawCommand($rawCommand);
    }
}
