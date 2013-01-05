#!/bin/sh

echo 'Installing SoulMeMaybe...'
git clone https://github.com/gnugat/SoulMeMaybe.git
cd ./SoulMeMaybe

echo 'Installing composer...'
curl -s http://getcomposer.org/installer | php

echo 'Installing SoulMeMaybe dependencies...'
php ./composer.phar install

echo 'Optimizing the autoloading...'
php ./composer.phar dump-autoload -o

echo 'SoulMeMaybe is now fully installed, you can run "php ./app/console" to use it'
