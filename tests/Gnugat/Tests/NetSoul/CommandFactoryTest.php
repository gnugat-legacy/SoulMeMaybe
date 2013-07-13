<?php

/*
 * This file is part of the SoulMeMaybe software.
 *
 * (c) Loïc Chardonnet <loic.chardonnet@gmail.com>
 *
 * For the full copyright and license information, please view the `/LICENSE.md`
 * file that was distributed with this source code.
 */

namespace Gnugat\Tests\NetSoul;

use Exception;

use Gnugat\NetSoul\CommandFactory;
use Gnugat\NetSoul\Commands;

use PHPUnit_Framework_TestCase;

class CommandFactoryTest extends PHPUnit_Framework_TestCase
{
    public function testSuccessfulMake()
    {
        $namesAndClasses = array(
            Commands\NewConnection::NAME => 'NewConnection',
        );

        $factory = new CommandFactory();

        foreach ($namesAndClasses as $name => $class) {
            $namespacedClass = 'Gnugat\\NetSoul\\Commands\\'.$class;

            $this->assertTrue($factory->make($name) instanceof $namespacedClass);
        }
    }

    /**
     * @expectedException Exception
     */
    public function testMakeFailure()
    {
        $factory = new CommandFactory();

        $factory->make('FakeCommand');
    }
}
