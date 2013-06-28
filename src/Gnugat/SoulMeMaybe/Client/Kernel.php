<?php

/*
 * This file is part of the SoulMeMaybe software.
 *
 * (c) Loïc Chardonnet <loic.chardonnet@gmail.com>
 *
 * For the full copyright and license information, please view the `/LICENSE.md`
 * file that was distributed with this source code.
 */

namespace Gnugat\SoulMeMaybe\Client;

use Gnugat\SoulMeMaybe\NetSoulProtocol\Request\AuthenticationRequest;
use Gnugat\SoulMeMaybe\NetSoulProtocol\Request\ExitRequest;
use Gnugat\SoulMeMaybe\NetSoulProtocol\Request\PingRequest;
use Gnugat\SoulMeMaybe\NetSoulProtocol\Request\StartAuthenticationRequest;
use Gnugat\SoulMeMaybe\NetSoulProtocol\Request\StateRequest;
use Gnugat\SoulMeMaybe\NetSoulProtocol\Response\ConnectionResponse;
use Gnugat\SoulMeMaybe\NetSoulProtocol\Response\EverythingIsFineResponse;
use Gnugat\SoulMeMaybe\NetSoulProtocol\Response\PingResponse;
use Gnugat\SoulMeMaybe\Output;

use Monolog\Logger;

/**
 * A NetSoul client, where methods implements each steps of the NetSoul
 * protocol.
 */
class Kernel
{
    /**
     * @var array
     */
    private $parameters;

    /**
     * @var Output
     */
    private $output;

    /**
     * @var integer
     */
    private $fileDescriptor;

    /**
     * @var ConnectionResponse
     */
    private $connectionResponse;

    /**
     * @param array                      $parameters
     * @param \Gnugat\SoulMeMaybe\Output $output
     */
    public function __construct($parameters, Output $output)
    {
        $this->parameters = $parameters;
        $this->output = $output;
    }

    /**
     * Creates a socket to open a connection with the NetSoul server.
     */
    public function connect()
    {
        $this->fileDescriptor = @fsockopen(
            $this->parameters['server_host'],
            $this->parameters['server_port']
        );

        if (false === $this->fileDescriptor) {
            $this->output->manageMessageOfGivenLogLevel('Error: Could not connect to the NetSoul server', Logger::CRITICAL);
            die();
        }

        $rawResponse = fgets($this->fileDescriptor);
        $this->output->manageMessageOfGivenLogLevel('Server: '.$rawResponse, Logger::INFO);

        $this->connectionResponse = new ConnectionResponse();
        $this->connectionResponse->setAttributesFromRawResponse($rawResponse);
    }

    /**
     * Requests an authentication and sends login information.
     */
    public function authenticate()
    {
        $startAuthenticationRequest = new StartAuthenticationRequest();
        $rawRequest = $startAuthenticationRequest->getRawRequestFromAttribute();

        $this->output->manageMessageOfGivenLogLevel('Client: '.$rawRequest, Logger::INFO);
        fwrite($this->fileDescriptor, $rawRequest);

        $rawResponse = fgets($this->fileDescriptor);
        $this->output->manageMessageOfGivenLogLevel('Server: '.$rawResponse, Logger::INFO);

        $everythingIsFineResponse = new EverythingIsFineResponse();
        $everythingIsFineResponse->setAttributesFromRawResponse($rawResponse);

        $authenticationRequest = new AuthenticationRequest($this->connectionResponse, $this->parameters);
        $rawRequest = $authenticationRequest->getRawRequestFromAttribute();
        fwrite($this->fileDescriptor, $rawRequest);
        $this->output->manageMessageOfGivenLogLevel('Client: '.$rawRequest, Logger::INFO);

        $rawResponse = fgets($this->fileDescriptor);
        $this->output->manageMessageOfGivenLogLevel('Server: '.$rawResponse, Logger::INFO);
        $everythingIsFineResponse = new EverythingIsFineResponse();
        $everythingIsFineResponse->setAttributesFromRawResponse($rawResponse);
    }

    /**
     * Defines the user as active.
     */
    public function state()
    {
        $stateRequest = new StateRequest(StateRequest::$states[0]);
        $rawRequest = $stateRequest->getRawRequestFromAttribute();

        $this->output->manageMessageOfGivenLogLevel('Client: '.$rawRequest, Logger::INFO);
        fwrite($this->fileDescriptor, $rawRequest);
    }

    /**
     * Pings the server to keep the connection alive.
     */
    public function ping()
    {
        $rawResponse = fgets($this->fileDescriptor);
        if (false !== $rawResponse) {
            $this->output->manageMessageOfGivenLogLevel('Server: '.$rawResponse, Logger::INFO);
            $pingResponse = new PingResponse();
            $pingResponse->setAttributesFromRawResponse($rawResponse);

            $pingRequest = new PingRequest();
            $rawRequest = $pingRequest->getRawRequestFromAttribute();
            fwrite($this->fileDescriptor, $rawRequest);
            $this->output->manageMessageOfGivenLogLevel('Client: '.$rawRequest, Logger::INFO);
        }
    }

    /**
     * Tells the server that the client is closing the connection and closes
     * the socket.
     */
    public function __destruct()
    {
        $exitRequest = new ExitRequest();
        $rawRequest = $exitRequest->getRawRequestFromAttribute();

        $this->output->manageMessageOfGivenLogLevel('Client: '.$rawRequest, Logger::INFO);
        fwrite($this->fileDescriptor, $rawRequest);

        fclose($this->fileDescriptor);
    }
}
