# Optimization

If you want to insignificantly speed up **SoulMeMaybe**, you can read the
following tips.

## Composer class autoloading

[Composer](http://getcomposer.org/), used as the dependency manager and as
the class auto loader of the project, [describes in its documentation a way to
optimize the autoloading](http://getcomposer.org/doc/03-cli.md#dump-autoload).

You just have to run the following command (after installing or updating
SoulMeMaybe):

    php ./composer.phar dump-autoload --optimize
