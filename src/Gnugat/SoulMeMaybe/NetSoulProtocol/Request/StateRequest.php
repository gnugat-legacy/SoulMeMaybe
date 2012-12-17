<?php

namespace Gnugat\SoulMeMaybe\NetSoulProtocol\Request;

/**
 * State request class.
 *
 * @author Loic Chardonnet <loic.chardonnet@gmail.com>
 */
class StateRequest extends AbstractRequest
{
    /** @var string The command name. */
    public $commandName = 'state';

    /** @var string The state and timestamp. */
    public $stateAndTimestamp;

    /**
     * The constructor.
     */
    public function __construct()
    {
        $this->stateAndTimestamp = implode(':', array(
            'active',
            strval(time()),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getRawRequestFromAttribute()
    {
        return $this->putsAttributeValuesInRawRequest(array(
            $this->commandName,
            $this->stateAndTimestamp,
        ));
    }
}
