<?php

namespace Gnugat\SoulMeMaybe\NetSoulProtocol\Request;

/**
 * Exit request class.
 *
 * @author Loic Chardonnet <loic.chardonnet@gmail.com>
 */
class ExitRequest extends AbstractRequest
{
    /** @var string The command name. */
    public $commandName = 'exit';

    /**
     * {@inheritdoc}
     */
    public function getRawRequestFromAttribute()
    {
        return $this->putsAttributeValuesInRawRequest(array(
            $this->commandName
        ));
    }
}
