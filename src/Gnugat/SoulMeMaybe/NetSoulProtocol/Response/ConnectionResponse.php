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
 * The response of the server when a client connects to it.
 */
class ConnectionResponse extends AbstractResponse
{
    /**
     * @var string
     */
    public $commandName;

    /**
     * @var integer
     */
    public $fileDescriptor;

    /**
     * @var string
     */
    public $hashSeed;

    /**
     * @var string
     */
    public $clientHost;

    /**
     * @var integer
     */
    public $clientPort;

    /**
     * @var integer
     */
    public $connectionTimestamp;

    /**
     * {@inheritdoc}
     */
    public function setAttributesFromRawResponse($rawResponse)
    {
        $attributeNames = array(
            'commandName',
            'fileDescriptor',
            'hashSeed',
            'clientHost',
            'clientPort',
            'connectionTimestamp',
        );

        $this->putsRawResponseValuesInAttributesByTheirNames($rawResponse, $attributeNames);
    }
}
