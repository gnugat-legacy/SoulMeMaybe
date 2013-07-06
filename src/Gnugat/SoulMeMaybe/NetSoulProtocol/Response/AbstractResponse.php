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
 * A representation of a NetSoul response where attributes are its fields, such
 * as command name or code number.
 *
 * There is no need to initialize the attributes, as they will be set by the
 * raw response.
 */
abstract class AbstractResponse
{
    /**
     * Defines an array containing the attribute names and passes it, along
     * side with the raw response, to `putsRawResponseValuesInAttributesByTheirNames`.
     *
     * @param string $rawResponse
     */
    abstract public function setAttributesFromRawResponse($rawResponse);

    /**
     * Puts raw response values in the attributes by their names.
     *
     * @param string $rawResponseValues
     * @param array  $attributeNames
     */
    protected function putsRawResponseValuesInAttributesByTheirNames($rawResponseValues, $attributeNames)
    {
        $responseValues = explode(' ', $rawResponseValues);
        foreach ($attributeNames as $responseIndex => $attributeName) {
            $this->$attributeName = $responseValues[$responseIndex];
        }
    }
}
