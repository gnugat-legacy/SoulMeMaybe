# Alternate installation

The installation described in the `README.md` file is the quickest and easiest.

If you prefer to clone the repository, in order to update easily
**SoulMeMaybe**, you can use instead the following commands:

    git clone https://github.com/gnugat/SoulMeMaybe.git
    cd ./SoulMeMaybe
    curl -s http://getcomposer.org/installer | php
    php ./composer.phar install

This will also ask you your login and password socks to create the
configuration into the `./config/parameters.yml` file.

# Updating the project

If you've followed the above instructions, updating **SoulMeMaybe** can simply
be done with the following commands:

    git pull
    php ./composer.phar self-update
    php ./composer.phar update