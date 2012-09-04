<?php

namespace Gnugat\SoulMeMaybe\NetSoulProtocol;

/**
 * Authentication request class.
 *
 * @author Loic Chardonnet <loic.chardonnet@gmail.com>
 */
class AuthenticationRequest
{
    /**
     * @var string The command name.
     */
    public $commandName = 'auth_ag';

    /**
     * @var integer The first argument.
     */
    public $firstArgument = 'ext_user';

    /**
     * @var integer The second argument.
     */
    public $secondArgument = 'none';

    /**
     * @var integer The third argument.
     */
    public $thirdArgument = 'none';

    /**
     * {@inheritdoc}
     */
    public function getRawRequestFromAttribute()
    {
        return $this->putsAttributeValuesInRawRequest(array(
            $this->commandName,
            $this->firstArgument,
            $this->secondArgument,
            $this->thirdArgument,
        ));
    }
}
