<?php

namespace Gnugat\SoulMeMaybe\Configurator;

use Symfony\Component\Console\Helper\DialogHelper,
    Symfony\Component\Console\Output\OutputInterface;

/**
 * Kernel class.
 *
 * @author Loic Chardonnet <loic.chardonnet@gmail.com>
 */
class Kernel
{
    /** @var \Symfony\Component\Console\Output\OutputInterface The output. */
    private $output;

    /** @var \Symfony\Component\Console\Helper\DialogHelper The dialog helper */
    private $dialogHelper;

    /** @var string The user login. */
    private $userLogin;

    /** @var string The password socks. */
    private $passwordSocks;

    /**
     * The constructor.
     *
     * @param \Symfony\Component\Console\Output\OutputInterface $output       The output.
     * @param \Symfony\Component\Console\Helper\DialogHelper    $dialogHelper The dialog helper.
     */
    public function __construct(OutputInterface $output, DialogHelper $dialogHelper)
    {
        $this->output = $output;
        $this->dialogHelper = $dialogHelper;
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
        $this->passwordSocks = $this->dialogHelper->ask(
            $this->output,
            'Enter your password socks: '
        );
    }

    /**
     * Writes the '/app/config/parameters.yml' file.
     */
    public function writeParametersFile()
    {
        $configDirectoryPath = __DIR__.'/../../../../app/config/';

        $parametersContent = file_get_contents($configDirectoryPath.'parameters.yml.dist');

        $parametersContent = str_replace('YourLogin', $this->userLogin, $parametersContent);
        $parametersContent = str_replace('YourPasswordSocks', $this->passwordSocks, $parametersContent);

        file_put_contents($configDirectoryPath.'parameters.yml', $parametersContent);

        $this->output->writeln('Parameters file created');
    }
}
