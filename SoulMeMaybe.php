<?php

use Gnugat\SoulMeMaybe\Application;

require __DIR__.'/vendor/autoload.php';

/**
 * Main file instanciating the Application.
 *
 * @author Loic Chardonnet <loic.chardonnet@gmail.com>
 */
$application = new Application();

$application->run();
