#!/bin/sh

echo 'Installing SoulMeMaybe...'
git clone https://github.com/gnugat/SoulMeMaybe.git
cd ./SoulMeMaybe
chmod +x ./bin/*

echo 'Installing composer...'
curl -s http://getcomposer.org/installer | php

echo 'Installing SoulMeMaybe dependencies...'
php ./composer.phar install

echo 'Optimizing the autoloading...'
php ./composer.phar dump-autoload -o

echo 'You can run "php ./SoulMeMaybe/app/console" to use it'
