<?php

namespace Gnugat\SoulMeMaybe\NetSoulProtocol;

/**
 * Abstract response class.
 *
 * @author Loic Chardonnet <loic.chardonnet@gmail.com>
 */
abstract class AbstractResponse
{
    /**
     * Sets the response class from the raw response.
     *
     * @param string $rawResponse The raw response.
     */
    abstract public function setFromRawResponse($rawResponse);

    /**
     * Sets the attributes values from the attributes names and the raw response.
     *
     * @param array $attributeNames The attribute names.
     * @param string $rawResponse The raw response.
     */
    protected function make($attributeNames, $rawResponse)
    {
        $responseValues = explode(' ', $rawResponse);
        foreach ($attributeNames as $responseIndex => $attributeName) {
            $this->$attributeName = $responseValues[$responseIndex];
        }
    }
}
