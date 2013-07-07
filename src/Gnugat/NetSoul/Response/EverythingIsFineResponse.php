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
 * The generic response sent by the server.
 */
class EverythingIsFineResponse extends AbstractResponse
{
    /**
     * @var string
     */
    public $commandName;

    /**
     * @var integer
     */
    public $codeNumber;

    /**
     * @var string
     */
    public $separator;

    /**
     * @var string
     */
    public $firstWordMessage;

    /**
     * @var string
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
