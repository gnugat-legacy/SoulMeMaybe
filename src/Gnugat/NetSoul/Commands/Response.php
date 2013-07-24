<?php

/*
 * This file is part of the SoulMeMaybe software.
 *
 * (c) Loïc Chardonnet <loic.chardonnet@gmail.com>
 *
 * For the full copyright and license information, please view the `/LICENSE.md`
 * file that was distributed with this source code.
 */

namespace Gnugat\NetSoul\Commands;

use Exception;

use Gnugat\NetSoul\RawCommand;

/**
 * Command sent by the server after receiving some specific commands from the
 * client.
 */
class Response implements Command
{
    const NAME = 'rep';
    const NUMBER_OF_PARAMETERS = 3;
    const VALID_SEPARATOR = '--';

    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $separator;

    /**
     * @var string
     */
    private $message;

    /**
     * {@inheritDoc}
     */
    public static function makeFromRawCommand(RawCommand $rawCommand)
    {
        $name = $rawCommand->getName();
        if (self::NAME !== $name) {
            throw new Exception(sprintf(
                'Wrong command name: %s given, expected %s',
                $name,
                self::NAME
            ));
        }

        $parameters = $rawCommand->getParameters();
        $numberOfParameters = count($parameters);
        if (self::NUMBER_OF_PARAMETERS >= $numberOfParameters) {
            throw new Exception(sprintf(
                'Wrong number of parameters: %s given, expected %s',
                $numberOfParameters,
                self::NUMBER_OF_PARAMETERS
            ));
        }

        $response = new Response();

        $response->code = array_shift($parameters);
        $response->separator = array_shift($parameters);

        if (self::VALID_SEPARATOR !== $response->separator) {
            throw new Exception(sprintf(
                'Invalid separator: %s given, expected %s',
                $response->separator,
                self::VALID_SEPARATOR
            ));
        }
        $response->message = implode(' ', $parameters);

        return $response;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getSeparator()
    {
        return $this->separator;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }
}
