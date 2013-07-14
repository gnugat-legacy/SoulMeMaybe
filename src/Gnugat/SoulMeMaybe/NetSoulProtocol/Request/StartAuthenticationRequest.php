<?php

/*
 * This file is part of the SoulMeMaybe software.
 *
 * (c) Loïc Chardonnet <loic.chardonnet@gmail.com>
 *
 * For the full copyright and license information, please view the `/LICENSE.md`
 * file that was distributed with this source code.
 */

namespace Gnugat\SoulMeMaybe\NetSoulProtocol\Request;

/**
 * Request to ask the server the autorization to authenticate.
 */
class StartAuthenticationRequest extends AbstractRequest
{
    /**
     * @var string
     */
    public $commandName = 'auth_ag';

    /**
     * @var string
     */
    public $authenticationType = 'ext_user';

    /**
     * @var string
     */
    public $firstUnusedArgument = 'none';

    /**
     * @var string
     */
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
