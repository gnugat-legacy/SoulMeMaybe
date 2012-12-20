<?php

namespace Gnugat\SoulMeMaybe;

use Gnugat\SoulMeMaybe\Output,
    Gnugat\SoulMeMaybe\NetSoulProtocol\Response\ConnectionResponse,
    Gnugat\SoulMeMaybe\NetSoulProtocol\Request\StartAuthenticationRequest,
    Gnugat\SoulMeMaybe\NetSoulProtocol\Response\EverythingIsFineResponse,
    Gnugat\SoulMeMaybe\NetSoulProtocol\Request\AuthenticationRequest,
    Gnugat\SoulMeMaybe\NetSoulProtocol\Request\StateRequest,
    Gnugat\SoulMeMaybe\NetSoulProtocol\Response\PingResponse,
    Gnugat\SoulMeMaybe\NetSoulProtocol\Request\PingRequest;

use Monolog\Logger;

/**
 * Kernel class.
 *
 * @author Loic Chardonnet <loic.chardonnet@gmail.com>
 */
class Kernel
{
    /** @var array The parameters. */
    private $parameters;

    /** @var \Gnugat\SoulMeMaybe\Output The ouput. */
    private $output;

    /** @var integer The file descriptor. */
    private $fileDescriptor;

    /** @var \Gnugat\SoulMeMaybe\NetSoulProtocol\Response\ConnectionResponse The connection response. */
    private $connectionResponse;

    /**
     * The constructor.
     *
     * @param array                      $parameters The parameters.
     * @param \Gnugat\SoulMeMaybe\Output $output     The output.
     */
    public function __construct($parameters, Output $output)
    {
        $this->parameters = $parameters;
        $this->output = $output;
    }

    /**
     * Connects to the NetSoul server.
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
     * Authenticates the user.
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
     * Defines the state.
     */
    public function state()
    {
        $stateRequest = new StateRequest();
        $rawRequest = $stateRequest->getRawRequestFromAttribute();

        $this->output->manageMessageOfGivenLogLevel('Client: '.$rawRequest, Logger::INFO);
        fwrite($this->fileDescriptor, $rawRequest);
    }

    /**
     * Pings the server.
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
}
