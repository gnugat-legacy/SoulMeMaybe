#!/bin/sh

echo 'Updating SoulMeMaybe...'
git pull

echo 'Updating composer...'
php ./composer.phar self-update

echo 'Updating SoulMeMaybe dependencies...'
php ./composer.phar update

echo 'Optimizing the autoloading...'
php ./composer.phar dump-autoload -o
