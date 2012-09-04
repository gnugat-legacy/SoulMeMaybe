<?php

namespace Gnugat\SoulMeMaybe\NetSoulProtocol;

/**
 * Connection response class.
 *
 * @author Loic Chardonnet <loic.chardonnet@gmail.com>
 */
class ConnectionResponse extends AbstractResponse
{
    /**
     * @var string The command name.
     */
    public $commandName;

    /**
     * @var integer The socket number.
     */
    public $socketNumber;

    /**
     * @var string The hash seed.
     */
    public $hashSeed;

    /**
     * @var string The client host.
     */
    public $clientHost;

    /**
     * @var integer The client port.
     */
    public $clientPort;

    /**
     * @var integer The server timestamp.
     */
    public $serverTimestamp;

    /**
     * {@inheritdoc}
     */
    public function setFromRawResponse($rawResponse)
    {
        $attributeNames = array(
            'commandName',
            'socketNumber',
            'hashSeed',
            'clientHost',
            'clientPort',
            'serverTimestamp',
        );

        $this->make($attributeNames, $rawResponse);
    }
}
