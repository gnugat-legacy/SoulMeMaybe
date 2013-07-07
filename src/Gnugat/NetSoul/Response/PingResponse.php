<?php

/*
 * This file is part of the SoulMeMaybe software.
 *
 * (c) Loïc Chardonnet <loic.chardonnet@gmail.com>
 *
 * For the full copyright and license information, please view the `/LICENSE.md`
 * file that was distributed with this source code.
 */

namespace Gnugat\NetSoul\Response;

/**
 * Message sent reguarly by the server to check if the client is still
 * connected.
 */
class PingResponse extends AbstractResponse
{
    /**
     * @var string
     */
    public $commandName;

    /**
     * @var integer
     */
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
