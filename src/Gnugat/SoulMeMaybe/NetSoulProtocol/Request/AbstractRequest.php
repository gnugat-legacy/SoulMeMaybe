<?php

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
