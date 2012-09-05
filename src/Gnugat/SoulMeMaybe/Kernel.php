<?php

namespace Gnugat\SoulMeMaybe;

use Symfony\Component\Yaml\Yaml;

use Gnugat\SoulMeMaybe\NetSoulProtocol\Response\ConnectionResponse,
    Gnugat\SoulMeMaybe\NetSoulProtocol\Request\StartAuthenticationRequest,
    Gnugat\SoulMeMaybe\NetSoulProtocol\Response\EverythingIsFineResponse,
    Gnugat\SoulMeMaybe\NetSoulProtocol\Request\AuthenticationRequest;

/**
 * Kernel class.
 *
 * @author Loic Chardonnet <loic.chardonnet@gmail.com>
 */
class Kernel
{
    /**
     * @var array The parameters.
     */
    private $parameters;

    /**
     * @var integer The file descriptor.
     */
    private $fileDescriptor;

    /**
     * @var \Gnugat\SoulMeMaybe\NetSoulProtocol\Response\ConnectionResponse The connection response.
     */
    private $connectionResponse;

    /**
     * The constructor.
     *
     * @param string $parametersFilePath The parameters file path.
     */
    public function __construct($parametersFilePath)
    {
        $this->parameters = Yaml::parse($parametersFilePath)['parameters'];
    }

    /**
     * Connects to the NetSoul server.
     *
     * @throws \Exception
     */
    public function connect()
    {
        $this->fileDescriptor = fsockopen(
            $this->parameters['server_host'],
            $this->parameters['server_port']
        );

        if (false === $this->fileDescriptor) {
            throw new \Exception("Error: Could not connect to the NetSoul server\n");
        }

        $rawResponse = fgets($this->fileDescriptor);

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
        fwrite($this->fileDescriptor, $rawRequest);

        $rawResponse = fgets($this->fileDescriptor);
        $everythingIsFineResponse = new EverythingIsFineResponse();
        $everythingIsFineResponse->setAttributesFromRawResponse($rawResponse);

        $authenticationRequest = new AuthenticationRequest($this->connectionResponse, $this->parameters);
        $rawRequest = $authenticationRequest->getRawRequestFromAttribute();
        fwrite($this->fileDescriptor, $rawRequest);

        $rawResponse = fgets($this->fileDescriptor);
        $everythingIsFineResponse = new EverythingIsFineResponse();
        $everythingIsFineResponse->setAttributesFromRawResponse($rawResponse);
    }
}
