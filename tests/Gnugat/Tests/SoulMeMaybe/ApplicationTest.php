<?php

namespace Gnugat\Tests\SoulMeMaybe;

use Gnugat\SoulMeMaybe\Application,
    Gnugat\Tests\Fixtures\PublicOutputCommand;

use Symfony\Component\Console\Formatter\OutputFormatterStyle,
    Symfony\Component\Console\Output\ConsoleOutput;

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

    public function testRun()
    {
        $command = new PublicOutputCommand();
        $application = new Application();
        $application->setAutoExit(false);

        $application->add($command);
        $_SERVER['argv'] = array('cli.php', $command->getName());

        ob_start();
        $application->run();
        ob_end_clean();

        $this->assertSame(ConsoleOutput::VERBOSITY_NORMAL, $command->output->getVerbosity());

        $expectedHighlightFormater = new OutputFormatterStyle('red');
        $actualHighlightFormater = $command->output->getFormatter()->getStyle('highlight');
        $this->assertSame($expectedHighlightFormater->apply('test'), $actualHighlightFormater->apply('test'));

        $expectedWarningFormater = new OutputFormatterStyle('black', 'yellow');
        $actualWarningFormater = $command->output->getFormatter()->getStyle('warning');
        $this->assertSame($expectedWarningFormater->apply('test'), $actualWarningFormater->apply('test'));
    }
}
