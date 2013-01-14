# Update

As described in the `README.md` file, the `bin/update.sh` script allows you to
easily update **SoulMeMaybe** to get the patches and new functionalities.

This file will describe how the `bin/update.sh` works.

## 1) Pulling changes

The `Updating SoulMeMaybe...` section of the script simply gets the changes
made to the source of the project.

## 2) Updating composer

The `Updating composer...` section of the script will update composer to get
its own patches and improvements.

## 3) Updating the dependencies

Some bugs found in **SoulMeMaybe** might come from its dependencies. By updating
them with the `Updating SoulMeMaybe dependencies...` section of the script we
can fix them, or get new functionnalities.

For example, the `symfony/console` dependency was used since its `2.1` version.
Updating it to the `2.2` version will provide support for autocompletion of
the commands.

## 4) Optimisation

Just as described in the `installation` documentation, we need to optimise the
autoloading of the dependencies once composer has updated them.

The `Optimising the autoloading...` section of the script will handle it.
