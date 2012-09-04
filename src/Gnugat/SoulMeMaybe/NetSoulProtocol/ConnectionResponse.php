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

    /**
     * Sets the attributes values from the attributes names and the raw response.
     *
     * @param array $attributeNames The attribute names.
     * @param string $rawResponse The raw response.
     */
    private function make($attributeNames, $rawResponse)
    {
        $responseValues = explode(' ', $rawResponse);
        foreach ($attributeNames as $responseIndex => $attributeName) {
            $this->$attributeName = $responseValues[$responseIndex];
        }
    }
}
