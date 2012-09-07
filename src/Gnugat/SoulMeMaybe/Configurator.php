<?php

namespace Gnugat\SoulMeMaybe;

/**
 * Configurator class.
 *
 * @author Loic Chardonnet <loic.chardonnet@gmail.com>
 */
class Configurator
{
    /**
     * @var string The user login.
     */
    private $userLogin;

    /**
     * @var string The password socks.
     */
    private $passwordSocks;

    /**
     * Gets the user login from CLI.
     */
    public function getUserLoginFromCli()
    {
        echo 'Enter your login: ';

        $input = fopen('php://stdin', 'r');
        $this->userLogin = trim(fgets($input));
        fclose($input);
    }

    /**
     * Gets the password socks from CLI.
     */
    public function getPasswordSocksFromCli()
    {
        echo 'Enter your password socks: ';

        $input = fopen('php://stdin', 'r');
        $this->passwordSocks = trim(fgets($input));
        fclose($input);
    }

    public function writeParametersFile()
    {
        $configDirectoryPath = __DIR__.'/../../../app/config/';

        $parametersContent = file_get_contents($configDirectoryPath.'parameters.yml.dist');

        $parametersContent = str_replace('user_login', $this->userLogin, $parametersContent);
        $parametersContent = str_replace('password_socks', $this->passwordSocks, $parametersContent);

        file_put_contents($configDirectoryPath.'parameters.yml', $parametersContent);

        echo "Parameters file created\n";
    }
}
