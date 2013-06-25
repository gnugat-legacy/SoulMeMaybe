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
