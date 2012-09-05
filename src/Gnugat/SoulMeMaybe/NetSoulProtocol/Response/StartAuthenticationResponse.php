<?php

namespace Gnugat\SoulMeMaybe\NetSoulProtocol\Response;

/**
 * Start authentication response class.
 *
 * @author Loic Chardonnet <loic.chardonnet@gmail.com>
 */
class StartAuthenticationResponse extends AbstractResponse
{
    /**
     * @var string The command name.
     */
    public $commandName;

    /**
     * @var integer The code number.
     */
    public $codeNumber;

    /**
     * @var string The separator.
     */
    public $separator;

    /**
     * @var string The request type.
     */
    public $requestType;

    /**
     * @var integer The message.
     */
    public $message;

    /**
     * {@inheritdoc}
     */
    public function setAttributesFromRawResponse($rawResponse)
    {
        $attributeNames = array(
            'commandName',
            'codeNumber',
            'separator',
            'requestType',
            'message',
        );

        $this->putsRawResponseValuesInAttributesByTheirNames($rawResponse, $attributeNames);
    }
}
