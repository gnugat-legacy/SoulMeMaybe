<?php

use Gnugat\SoulMeMaybe\Kernel;

require __DIR__.'/../vendor/autoload.php';

/**
 * Main file instanciating the Client and sending the requests.
 *
 * @author Loic Chardonnet <loic.chardonnet@gmail.com>
 */
try {
    $kernel = new Kernel(__DIR__.'/config/parameters.yml');
    $kernel->connect();
    $kernel->authenticate();
    $kernel->state();
    while (true) {
        $kernel->ping();
    }
} catch (\Exception $exception) {
    die($exception->getMessage());
}
