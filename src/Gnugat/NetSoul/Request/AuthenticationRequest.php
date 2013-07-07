<?php

/*
 * This file is part of the SoulMeMaybe software.
 *
 * (c) Loïc Chardonnet <loic.chardonnet@gmail.com>
 *
 * For the full copyright and license information, please view the `/LICENSE.md`
 * file that was distributed with this source code.
 */

namespace Gnugat\NetSoul\Request;

use Gnugat\NetSoul\Response\ConnectionResponse;

/**
 * The authentication request requires some parameters given by the user as
 * well as the Connection response.
 */
class AuthenticationRequest extends AbstractRequest
{
    /**
     * @var string
     */
    public $commandName = 'ext_user_log';

    /**
     * @var string
     */
    public $userLogin;

    /**
     * @var string
     */
    public $authenticationHash;

    /**
     * @var string
     */
    public $clientDescription;

    /**
     * @var string
     */
    public $userLocation;

    /**
     * @param ConnectionResponse $connectionResponse
     * @param array              $parameters
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
