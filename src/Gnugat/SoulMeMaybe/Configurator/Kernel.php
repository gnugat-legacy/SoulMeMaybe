<?php

/*
 * This file is part of the SoulMeMaybe software.
 *
 * (c) Loïc Chardonnet <loic.chardonnet@gmail.com>
 *
 * For the full copyright and license information, please view the `/LICENSE.md`
 * file that was distributed with this source code.
 */

namespace Gnugat\SoulMeMaybe\Configurator;

use Gnugat\SoulMeMaybe\VersionExtractor;

use Symfony\Component\Console\Helper\DialogHelper;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Writes the given information to the configuration file.
 */
class Kernel
{
    /**
     * @var OutputInterface
     */
    private $output;

    /**
     * @var DialogHelper
     */
    private $dialogHelper;

    /**
     * @var VersionExtractor
     */
    private $versionExtractor;

    /**
     * @var string
     */
    private $userLogin;

    /**
     * @var string
     */
    private $passwordSocks;

    /**
     * @param OutputInterface  $output
     * @param DialogHelper     $dialogHelper
     * @param VersionExtractor $versionExtractor
     */
    public function __construct(OutputInterface $output, DialogHelper $dialogHelper, VersionExtractor $versionExtractor)
    {
        $this->output = $output;
        $this->dialogHelper = $dialogHelper;
        $this->versionExtractor = $versionExtractor;
    }

    /**
     * Gets the user login from CLI.
     */
    public function getUserLoginFromCli()
    {
        $this->userLogin = $this->dialogHelper->ask(
            $this->output,
            'Enter your login: '
        );
    }

    /**
     * Gets the password socks from CLI.
     */
    public function getPasswordSocksFromCli()
    {
        $this->passwordSocks = $this->dialogHelper->askHiddenResponse(
            $this->output,
            'Enter your password socks: '
        );
    }

    /**
     * Creates the `app/config/parameters.yml` configuration file based on
     * the `app/config/parameters.yml.dist` file and the given login and
     * password.
     * Also sets the current version in the client description.
     */
    public function writeParametersFile()
    {
        $configDirectoryPath = __DIR__.'/../../../../app/config';

        $parametersContent = file_get_contents($configDirectoryPath.'/parameters.yml.dist');

        $parametersContent = str_replace('YourLogin', $this->userLogin, $parametersContent);
        $parametersContent = str_replace('YourPasswordSocks', $this->passwordSocks, $parametersContent);
        $parametersContent = str_replace(
            'Version 2',
            $this->versionExtractor->getVersionNumber(),
            $parametersContent
        );

        file_put_contents($configDirectoryPath.'/parameters.yml', $parametersContent);

        $this->output->writeln('Parameters file created');
    }

    /**
     * Updates the `app/config/parameters.yml` configuration file based on
     * the given login and password.
     * Also tries to set the current version in the client description.
     */
    public function updateParametersFile()
    {
        $parametersFilePath = __DIR__.'/../../../../app/config/parameters.yml';
        $versionSelector = 'client_description: "SoulMeMaybe ';
        $endSelector = '"'.PHP_EOL;

        $parametersContent = file_get_contents($parametersFilePath);

        $selectorPosition = strpos($parametersContent, $versionSelector);
        if (false === $selectorPosition) {
            $this->output->writeln('Parameters file doesn\'t need to be updated');

            return;
        }

        $endOfLinePosition = strpos($parametersContent, $endSelector, $selectorPosition);
        if (false === $endOfLinePosition) {
            $this->output->writeln('An error occured, the parameters file seems messed up!');

            return;
        }

        $parametersContent = substr_replace(
            $parametersContent,
            $versionSelector.$this->versionExtractor->getVersionNumber(),
            $selectorPosition,
            $endOfLinePosition - $selectorPosition
        );

        file_put_contents($parametersFilePath, $parametersContent);

        $this->output->writeln('Parameters file updated');
    }
}
