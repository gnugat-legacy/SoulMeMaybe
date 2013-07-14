<?php

/*
 * This file is part of the SoulMeMaybe software.
 *
 * (c) Loïc Chardonnet <loic.chardonnet@gmail.com>
 *
 * For the full copyright and license information, please view the `/LICENSE.md`
 * file that was distributed with this source code.
 */

namespace Gnugat\NetSoul;

use Exception;

class RawCommand
{
    /**
     * @var string
     */
    private $name;
    
    /**
     * @var array
     */
    private $parameters;
    
    /**
     * @param string $command The sent or received string.
     */
    public function __construct($command)
    {
        if (false === strpos($command, PHP_EOL)) {
            throw new Exception(sprintf('Error: missing line ending in (%s)', $command));
        }
        
        $parsedCommand = trim($command);
        $commandParameters = explode(' ', $parsedCommand);
        
        if (empty($parsedCommand)) {
            throw new Exception('Error: empty string');
        }
        
        $this->name = array_shift($commandParameters);
        $this->parameters = $commandParameters;
    }
    
    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }
}
