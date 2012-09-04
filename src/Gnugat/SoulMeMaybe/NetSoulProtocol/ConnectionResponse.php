<?php

namespace Gnugat\SoulMeMaybe\NetSoulProtocol;

/**
 * Connection response class.
 *
 * @author Loic Chardonnet <loic.chardonnet@gmail.com>
 */
class ConnectionResponse
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
     * The constructor.
     *
     * @param integer $handler The handler.
     */
    public function __construct($handler)
    {
        $attributeNamesAndLinkedIndexes = array(
            'commandName' => 0,
            'socketNumber' => 1,
            'hashSeed' => 2,
            'clientHost' => 3,
            'clientPort' => 4,
            'serverTimestamp' => 5,
        );

        $rawResponse = fgets($handler);
        $responseAttributes = explode(' ', $rawResponse);
        foreach ($attributeNamesAndLinkedIndexes as $attributeName => $linkedIndex) {
            $this->$attributeName = $responseAttributes[$linkedIndex];
        }
    }
}
