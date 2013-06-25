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

use Symfony\Component\Console\Helper\DialogHelper,
    Symfony\Component\Console\Output\OutputInterface;

use Gnugat\SoulMeMaybe\VersionExtractor;

/**
 * Kernel class.
 *
 * @author Loic Chardonnet <loic.chardonnet@gmail.com>
 */
class Kernel
{
    /** @var \Symfony\Component\Console\Output\OutputInterface The output. */
    private $output;

    /** @var \Symfony\Component\Console\Helper\DialogHelper The dialog helper. */
    private $dialogHelper;

    /** @var \Gnugat\SoulMeMaybe\VersionExtractor */
    private $versionExtractor;

    /** @var string The user login. */
    private $userLogin;

    /** @var string The password socks. */
    private $passwordSocks;

    /**
     * The constructor.
     *
     * @param \Symfony\Component\Console\Output\OutputInterface $output       The output.
     * @param \Symfony\Component\Console\Helper\DialogHelper    $dialogHelper The dialog helper.
     * @param \Gnugat\SoulMeMaybe\VersionExtractor              $versionExtractor
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
     * Gets the content of the `app/config/parameters.yml.dist`.
     * Replaces the login and password with the given ones and replace the
     * version using the version extractor.
     * Then creates the `app/config/parameters.yml` file.
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
     * Gets the content of the `app/config/parameters.yml`.
     * Replaces the version using the version extractor.
     * Then saves the file.
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
