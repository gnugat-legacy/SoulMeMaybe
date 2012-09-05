<?php

namespace Gnugat\SoulMeMaybe\NetSoulProtocol\Response;

/**
 * Ping response class.
 *
 * @author Loic Chardonnet <loic.chardonnet@gmail.com>
 */
class PingResponse extends AbstractResponse
{
    /**
     * @var string The command name.
     */
    public $commandName;

    /**
     * @var integer The timeout in seconds.
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
    }
}
