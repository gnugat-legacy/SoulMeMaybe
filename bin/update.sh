#!/bin/sh

#
# This file is part of the SoulMeMaybe software.
#
# (c) Loïc Chardonnet <loic.chardonnet@gmail.com>
#
# For the full copyright and license information, please view the `/LICENSE.md`
# file that was distributed with this source code.
#

echo 'Updating SoulMeMaybe...'
git pull

echo 'Updating composer...'
php ./composer.phar self-update

echo 'Updating SoulMeMaybe dependencies...'
php ./composer.phar update

echo 'Optimising the autoloading...'
php ./composer.phar dump-autoload -o
