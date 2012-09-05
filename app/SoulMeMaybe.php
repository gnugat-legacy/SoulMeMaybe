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
} catch (\Exception $exception) {
    die($exception->getMessage());
}
