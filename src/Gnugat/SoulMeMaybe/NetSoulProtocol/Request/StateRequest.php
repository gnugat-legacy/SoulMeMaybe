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
 * State request class.
 *
 * @author Loic Chardonnet <loic.chardonnet@gmail.com>
 */
class StateRequest extends AbstractRequest
{
    /** @var array The states. */
    public static $states = array(
        'actif',
        'away',
        'connection',
        'idle',
        'lock',
        'server',
        'none',
    );

    /** @var string The command name. */
    public $commandName = 'state';

    /** @var string The state and timestamp. */
    public $stateAndTimestamp;

    /**
     * The constructor.
     *
     * @param string $state The state.
     */
    public function __construct($state)
    {
        $this->stateAndTimestamp = implode(':', array(
            $state,
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
