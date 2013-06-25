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
 * Connection response class.
 *
 * @author Loic Chardonnet <loic.chardonnet@gmail.com>
 */
class ConnectionResponse extends AbstractResponse
{
    /** @var string The command name. */
    public $commandName;

    /** @var integer The file descriptor. */
    public $fileDescriptor;

    /** @var string The hash seed. */
    public $hashSeed;

    /** @var string The client host. */
    public $clientHost;

    /** @var integer The client port. */
    public $clientPort;

    /** @var integer The connection timestamp. */
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
