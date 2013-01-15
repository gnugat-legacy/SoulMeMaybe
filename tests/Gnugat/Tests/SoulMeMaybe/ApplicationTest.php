<?php

namespace Gnugat\Tests\SoulMeMaybe;

use Gnugat\SoulMeMaybe\Application,
    Gnugat\Tests\Fixtures\PublicOutputCommand;

use Symfony\Component\Console\Formatter\OutputFormatterStyle,
    Symfony\Component\Console\Output\ConsoleOutput,
    Symfony\Component\Console\Tester\ApplicationTester;

use PHPUnit_Framework_TestCase;

/**
 * Application test class.
 *
 * @author Loic Chardonnet <loic.chardonnet@gmail.com>
 */
class ApplicationTest extends PHPUnit_Framework_TestCase
{
    protected static $fixturesPath;

    public static function setUpBeforeClass()
    {
        self::$fixturesPath = realpath(__DIR__.'/../Fixtures');
    }

    public function testName()
    {
        $application = new Application();

        $this->assertSame(Application::NAME, $application->getName());
    }

    public function testVersion()
    {
        $application = new Application();

        $this->assertSame(Application::VERSION, $application->getVersion());
    }

    public function testDefaultCommands()
    {
        $application = new Application();

        $defaultCommands = array(
            'client',
            'configurator',
            'help',
        );

        $this->assertEquals($defaultCommands, array_keys($application->all()));
    }

    public function testVerbosity()
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
    }

    public function testHighlightFormater()
    {
        $command = new PublicOutputCommand();
        $application = new Application();
        $application->setAutoExit(false);

        $application->add($command);
        $_SERVER['argv'] = array('cli.php', $command->getName());

        ob_start();
        $application->run();
        ob_end_clean();

        $expectedFormater = new OutputFormatterStyle('red');
        $actualFormater = $command->output->getFormatter()->getStyle('highlight');
        $this->assertSame($expectedFormater->apply('test'), $actualFormater->apply('test'));
    }

    public function testWarningFormater()
    {
        $command = new PublicOutputCommand();
        $application = new Application();
        $application->setAutoExit(false);

        $application->add($command);
        $_SERVER['argv'] = array('cli.php', $command->getName());

        ob_start();
        $application->run();
        ob_end_clean();

        $expectedFormater = new OutputFormatterStyle('black', 'yellow');
        $actualFormater = $command->output->getFormatter()->getStyle('warning');
        $this->assertSame($expectedFormater->apply('test'), $actualFormater->apply('test'));
    }

    public function testRunHelp()
    {
        $application = new Application();
        $application->setAutoExit(false);

        $tester = new ApplicationTester($application);

        $tester->run(array(), array('decorated' => false));
        $this->assertStringEqualsFile(self::$fixturesPath.'/run_help.txt', $tester->getDisplay());
    }
}
