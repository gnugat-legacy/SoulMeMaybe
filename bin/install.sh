#!/bin/sh

#
# This file is part of the SoulMeMaybe software.
#
# (c) Loïc Chardonnet <loic.chardonnet@gmail.com>
#
# For the full copyright and license information, please view the `/LICENSE.md`
# file that was distributed with this source code.
#

echo 'Installing SoulMeMaybe...'
git clone https://github.com/gnugat/SoulMeMaybe.git
cd ./SoulMeMaybe

echo 'Setting rights...'
chmod +x ./bin/* ./app/console

echo 'Installing composer...'
curl -s http://getcomposer.org/installer | php

echo 'Installing SoulMeMaybe dependencies...'
php ./composer.phar install

echo 'Optimising the autoloading...'
php ./composer.phar dump-autoload -o

echo 'You can run "php ./SoulMeMaybe/app/console" to use it'
