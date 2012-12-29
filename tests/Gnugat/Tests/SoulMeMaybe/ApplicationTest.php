<?php

namespace Gnugat\Tests\SoulMeMaybe;

use Gnugat\SoulMeMaybe\Application;

use PHPUnit_Framework_TestCase;

/**
 * Application test class.
 *
 * @author Loic Chardonnet <loic.chardonnet@gmail.com>
 */
class ApplicationTest extends PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $application = new Application();

        $this->assertSame(Application::NAME, $application->getName());
        $this->assertSame(Application::VERSION, $application->getVersion());

        $defaultCommands = array(
            'help',
            'list',
            'client',
            'configurator',
        );

        $this->assertEquals($defaultCommands, array_keys($application->all()));
    }
}
