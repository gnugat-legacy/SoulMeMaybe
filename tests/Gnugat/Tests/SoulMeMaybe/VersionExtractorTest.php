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

class VersionExtractorTest extends PHPUnit_Framework_TestCase
{
    public function testRetrievalOfVersionNumber()
    {
        $versionExtractor = new VersionExtractor(__DIR__.'/../Fixtures/version_file.md');

        // The version of the fixture file is static and set to 2.1.0
        $this->assertSame('2.1.0', $versionExtractor->getVersionNumber());
    }
}
