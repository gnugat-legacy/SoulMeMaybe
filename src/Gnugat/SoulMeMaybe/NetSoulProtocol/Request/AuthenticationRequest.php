<?php

namespace Gnugat\SoulMeMaybe\NetSoulProtocol\Request;

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
     * @var integer The user login.
     */
    public $userLogin;

    /**
     * @var integer The authentication hash.
     */
    public $authenticationHash;

    /**
     * @var integer The client description.
     */
    public $clientDescription;

    /**
     * @var integer The user location.
     */
    public $userLocation;

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
