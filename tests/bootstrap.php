<?php

/*
 * This file is part of the SoulMeMaybe software.
 *
 * (c) Loïc Chardonnet <loic.chardonnet@gmail.com>
 *
 * For the full copyright and license information, please view the `/LICENSE.md`
 * file that was distributed with this source code.
 */

/**
 * Registering the tests namespace to the autoloader.
 *
 * @author Loic Chardonnet <loic.chardonnet@gmail.com>
 */
$loader = require __DIR__.'/../vendor/autoload.php';
$loader->add('Gnugat\\Tests', __DIR__);
