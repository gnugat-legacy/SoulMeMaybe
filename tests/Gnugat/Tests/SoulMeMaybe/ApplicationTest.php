<?php

/*
 * This file is part of the SoulMeMaybe software.
 *
 * (c) Loïc Chardonnet <loic.chardonnet@gmail.com>
 *
 * For the full copyright and license information, please view the `/LICENSE.md`
 * file that was distributed with this source code.
 */

namespace Gnugat\Tests\SoulMeMaybe;

use Gnugat\SoulMeMaybe\Application,
    Gnugat\Tests\Fixtures\PublicOutputCommand;

use Gnugat\SoulMeMaybe\VersionExtractor;

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

        $_SERVER['PHP_SELF'] = 'app/console';
    }

    public function testName()
    {
        $application = new Application(new VersionExtractor(self::$fixturesPath.'/version_file.md'));

        $this->assertSame(Application::NAME, $application->getName());
    }

    public function testVersion()
    {
        $application = new Application(new VersionExtractor(self::$fixturesPath.'/version_file.md'));

        $this->assertSame('2.1.0', $application->getVersion());
    }

    public function testDefaultCommands()
    {
        $application = new Application(new VersionExtractor(self::$fixturesPath.'/version_file.md'));

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
        $application = new Application(new VersionExtractor(self::$fixturesPath.'/version_file.md'));
        $application->setAutoExit(false);

        $application->add($command);
        $_SERVER['argv'] = array('cli.php', $command->getName());

        ob_start();
        $application->run();
        ob_end_clean();

        $this->assertSame(ConsoleOutput::VERBOSITY_NORMAL, $command->output->getVerbosity());
    }

    public function testRunHelp()
    {
        $application = new Application(new VersionExtractor(self::$fixturesPath.'/version_file.md'));
        $application->setAutoExit(false);

        $tester = new ApplicationTester($application);

        $tester->run(array(), array('decorated' => false));
        $this->assertStringEqualsFile(self::$fixturesPath.'/run_help.txt', $tester->getDisplay());
    }
}
