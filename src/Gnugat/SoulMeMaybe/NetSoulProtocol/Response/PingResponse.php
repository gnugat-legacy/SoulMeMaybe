<?php

/*
 * This file is part of the SoulMeMaybe software.
 *
 * (c) Loïc Chardonnet <loic.chardonnet@gmail.com>
 *
 * For the full copyright and license information, please view the `/LICENSE.md`
 * file that was distributed with this source code.
 */

namespace Gnugat\SoulMeMaybe\NetSoulProtocol\Response;

/**
 * Ping response class.
 *
 * @author Loic Chardonnet <loic.chardonnet@gmail.com>
 */
class PingResponse extends AbstractResponse
{
    /** @var string The command name. */
    public $commandName;

    /** @var integer The timeout in seconds. */
    public $timeoutInSeconds;

    /**
     * {@inheritdoc}
     */
    public function setAttributesFromRawResponse($rawResponse)
    {
        $attributeNames = array(
            'commandName',
            'timeoutInSeconds',
        );

        $this->putsRawResponseValuesInAttributesByTheirNames($rawResponse, $attributeNames);

        $this->timeoutInSeconds = intval($this->timeoutInSeconds);
    }
}
