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

use Gnugat\SoulMeMaybe\VersionExtractor;

use PHPUnit_Framework_TestCase;

/**
 * Version extractor test class.
 *
 * @author Loic Chardonnet <loic.chardonnet@gmail.com>
 */
class VersionExtractorTest extends PHPUnit_Framework_TestCase
{
    public function test()
    {
        $versionExtractor = new VersionExtractor(__DIR__.'/../Fixtures/version_file.md');
        $this->assertSame('2.1.0', $versionExtractor->getVersionNumber());
    }
}
