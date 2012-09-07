<?php

namespace Gnugat\SoulMeMaybe\NetSoulProtocol\Request;

use Gnugat\SoulMeMaybe\NetSoulProtocol\Response\ConnectionResponse;

/**
 * Ping request class.
 *
 * @author Loic Chardonnet <loic.chardonnet@gmail.com>
 */
class PingRequest extends AbstractRequest
{
    /**
     * @var string The command name.
     */
    public $commandName = 'ping';

    /**
     * @var string The non mandatory argument.
     */
    public $nonMandatoryArgument;

    /**
     * The constructor
     */
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
