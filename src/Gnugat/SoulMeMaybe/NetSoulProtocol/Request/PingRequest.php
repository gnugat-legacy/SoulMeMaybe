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

use Gnugat\SoulMeMaybe\NetSoulProtocol\Response\ConnectionResponse;

/**
 * Ping answer to the server's one, to keep the connection alive.
 */
class PingRequest extends AbstractRequest
{
    /**
     * @var string
     */
    public $commandName = 'ping';

    /**
     * @var string
     */
    public $nonMandatoryArgument;

    public function __construct()
    {
        $this->nonMandatoryArgument = 'Hey, you just pinged me,'
            .' And this is crazy,'
            .' But here\'s my ping answer,'
            .' So soul me, maybe?'
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getRawRequestFromAttribute()
    {
        return $this->putsAttributeValuesInRawRequest(array(
            $this->commandName,
            $this->nonMandatoryArgument,
        ));
    }
}
