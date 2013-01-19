<?php

namespace Gnugat\SoulMeMaybe\NetSoulProtocol\Request;

/**
 * Start authentication request class.
 *
 * @author Loic Chardonnet <loic.chardonnet@gmail.com>
 */
class StartAuthenticationRequest extends AbstractRequest
{
    /** @var string The command name. */
    public $commandName = 'auth_ag';

    /** @var string The authentication type. */
    public $authenticationType = 'ext_user';

    /** @var string The unused argument 1. */
    public $firstUnusedArgument = 'none';

    /** @var string The unused argument 2. */
    public $secondUnusedArgument = 'none';

    /**
     * {@inheritdoc}
     */
    public function getRawRequestFromAttribute()
    {
        return $this->putsAttributeValuesInRawRequest(array(
            $this->commandName,
            $this->authenticationType,
            $this->firstUnusedArgument,
            $this->secondUnusedArgument,
        ));
    }
}
