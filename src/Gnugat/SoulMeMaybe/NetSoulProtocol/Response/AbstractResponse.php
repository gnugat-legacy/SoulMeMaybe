<?php

namespace Gnugat\SoulMeMaybe\NetSoulProtocol\Response;

/**
 * Abstract response class.
 *
 * @author Loic Chardonnet <loic.chardonnet@gmail.com>
 */
abstract class AbstractResponse
{
    /**
     * Sets the attributes from the raw response.
     *
     * @param string $rawResponse The raw response.
     */
    abstract public function setAttributesFromRawResponse($rawResponse);

    /**
     * Puts raw response values in the attributes by their names.
     *
     * @param string $rawResponseValues The raw response values.
     * @param array $attributeNames The attribute names.
     */
    protected function putsRawResponseValuesInAttributesByTheirNames($rawResponseValues, $attributeNames)
    {
        $responseValues = explode(' ', $rawResponseValues);
        foreach ($attributeNames as $responseIndex => $attributeName) {
            $this->$attributeName = $responseValues[$responseIndex];
        }
    }
}
