<?php

/*
 * This file is part of the SoulMeMaybe software.
 *
 * (c) Loïc Chardonnet <loic.chardonnet@gmail.com>
 *
 * For the full copyright and license information, please view the `/LICENSE.md`
 * file that was distributed with this source code.
 */

namespace Gnugat\SoulMeMaybe\NetSoulProtocol\Request;

/**
 * Abstract request class.
 *
 * @author Loic Chardonnet <loic.chardonnet@gmail.com>
 */
abstract class AbstractRequest
{
    /**
     * Gets the raw request from the attributes.
     *
     * @return string
     */
    abstract public function getRawRequestFromAttribute();

    /**
     * Puts raw response values in the attributes by their names.
     *
     * @param array $attributeValues The attribute values.
     *
     * @return string
     */
    protected function putsAttributeValuesInRawRequest($attributeValues)
    {
        $rawRequest = implode(' ', $attributeValues);

        return "$rawRequest\n";
    }
}
