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
 * Everything is fine response class.
 *
 * @author Loic Chardonnet <loic.chardonnet@gmail.com>
 */
class EverythingIsFineResponse extends AbstractResponse
{
    /** @var string The command name. */
    public $commandName;

    /** @var integer The code number. */
    public $codeNumber;

    /** @var string The separator. */
    public $separator;

    /** @var string The first word of the message. */
    public $firstWordMessage;

    /** @var string The second word of the message. */
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
