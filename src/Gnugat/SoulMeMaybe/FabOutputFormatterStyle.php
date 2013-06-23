<?php

namespace Gnugat\SoulMeMaybe;

use Fab\Fab;

use Symfony\Component\Console\Formatter\OutputFormatterStyleInterface;

/**
 * Paints each characters of the output with a random color.
 *
 * @author Loic Chardonnet <loic.chardonnet@gmail.com>
 */
class FabOutputFormatterStyle implements OutputFormatterStyleInterface
{
    /**
     * @param Fab\Fab $fab The dependency that will paint characters
     */
    public function __construct(Fab $fab)
    {
        $this->fab = $fab;
    }

    /**
     * {@inheritDoc}
     */
    public function setForeground($color = null)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function setBackground($color = null)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function setOption($option)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function unsetOption($option)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function setOptions(array $options)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function apply($text)
    {
        return $this->fab->paint($text);
    }
}
