<?php

/*
 * This file is part of the SoulMeMaybe software.
 *
 * (c) Loïc Chardonnet <loic.chardonnet@gmail.com>
 *
 * For the full copyright and license information, please view the `/LICENSE.md`
 * file that was distributed with this source code.
 */

namespace Gnugat\NetSoul\Request;

/**
 * A representation of a NetSoul request where attributes are its fields such
 * as command name or user login.
 *
 * You should initialize the attributes, on definition or in the constructor.
 */
abstract class AbstractRequest
{
    /**
     * Passes the Request's fields to the `putsAttributeValuesInRawRequest`
     * method and returns its result.
     *
     * @return string
     */
    abstract public function getRawRequestFromAttribute();

    /**
     * Creates a text request that can be sent directly to the NetSoul server.
     *
     * @param array $attributeValues
     *
     * @return string
     */
    protected function putsAttributeValuesInRawRequest($attributeValues)
    {
        $rawRequest = implode(' ', $attributeValues);

        return "$rawRequest\n";
    }
}
