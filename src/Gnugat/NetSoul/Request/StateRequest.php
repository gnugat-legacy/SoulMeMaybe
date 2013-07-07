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

/**
 * The status of the user (active, away, etc).
 */
class StateRequest extends AbstractRequest
{
    /**
     * @var array
     */
    public static $states = array(
        'actif',
        'away',
        'connection',
        'idle',
        'lock',
        'server',
        'none',
    );

    /**
     * @var string
     */
    public $commandName = 'state';

    /**
     * @var string
     */
    public $stateAndTimestamp;

    /**
     * @param string $state
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
