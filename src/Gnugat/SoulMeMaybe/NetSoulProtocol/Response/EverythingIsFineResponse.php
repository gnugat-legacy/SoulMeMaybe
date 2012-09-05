<?php

namespace Gnugat\SoulMeMaybe\NetSoulProtocol\Response;

/**
 * Everything is fine response class.
 *
 * @author Loic Chardonnet <loic.chardonnet@gmail.com>
 */
class EverythingIsFineResponse extends AbstractResponse
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
     * @var string The first word of the message.
     */
    public $firstWordMessage;

    /**
     * @var string The second word of the message.
     */
    public $secondWordMessage;

    /**
     * {@inheritdoc}
     */
    public function setAttributesFromRawResponse($rawResponse)
    {
        $attributeNames = array(
            'commandName',
            'codeNumber',
            'separator',
            'firstWordMessage',
            'secondWordMessage',
        );

        $this->putsRawResponseValuesInAttributesByTheirNames($rawResponse, $attributeNames);
    }
}
