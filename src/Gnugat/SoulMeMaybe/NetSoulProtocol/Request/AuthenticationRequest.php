<?php

namespace Gnugat\SoulMeMaybe\NetSoulProtocol\Request;

use Gnugat\SoulMeMaybe\NetSoulProtocol\Response\ConnectionResponse;

/**
 * Authentication request class.
 *
 * @author Loic Chardonnet <loic.chardonnet@gmail.com>
 */
class AuthenticationRequest extends AbstractRequest
{
    /**
     * @var string The command name.
     */
    public $commandName = 'ext_user_log';

    /**
     * @var string The user login.
     */
    public $userLogin;

    /**
     * @var string The authentication hash.
     */
    public $authenticationHash;

    /**
     * @var string The client description.
     */
    public $clientDescription;

    /**
     * @var string The user location.
     */
    public $userLocation;

    /**
     * The constructor.
     *
     * @param \Gnugat\SoulMeMaybe\NetSoulProtocol\Response\ConnectionResponse $connectionResponse The connection response.
     * @param array                                                           $parameters         The parameters.
     */
    public function __construct(ConnectionResponse $connectionResponse, array $parameters)
    {
        $this->userLogin = $parameters['user_login'];
        $this->authenticationHash = md5(
            $connectionResponse->hashSeed
            . '-'
            . $connectionResponse->clientHost
            . '/'
            . $connectionResponse->clientPort
            . $parameters['password_socks']
        );
        $this->clientDescription = rawurlencode($parameters['client_description']);
        $this->userLocation = rawurlencode($parameters['user_location']);
    }

    /**
     * {@inheritdoc}
     */
    public function getRawRequestFromAttribute()
    {
        return $this->putsAttributeValuesInRawRequest(array(
            $this->commandName,
            $this->userLogin,
            $this->authenticationHash,
            $this->clientDescription,
            $this->userLocation,
        ));
    }
}
