# Installation

There's many way to install SoulMeMaybe, mainly using git and composer.
If you don't have Composer yet, download it following the instructions on
http://getcomposer.org/ or just run the following command:

    curl -s http://getcomposer.org/installer | php

## Composer create-project

Run the `create-project` command from composer to install the project:

    php composer.phar create-project gnugat/soul-me-maybe

This will create a folder `soul-me-maybe` with the NetSoul client inside and
will ask you your login and password socks, to create the configuration.

## Git clone and composer install

Another way to install SoulMeMaybe is to directly clone the repository and then
using the `install` command from composer to get the dependencies:

    git clone https://github.com/gnugat/SoulMeMaybe.git
    cd ./SoulMeMaybe
    php composer.phar install

This will get the main application inside the SoulMeMaybe folder, and then ask
you your login and password socks.

# Configuration

The file `app/config/parameters.yml` can be edited to configure SoulMeMaybe.

# Usage

To use SoulMeMaybe, just run `php app/SoulMeMaybe.php`.
