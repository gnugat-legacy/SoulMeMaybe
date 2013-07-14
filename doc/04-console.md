# Console

To use **SoulMeMaybe**, just run the console with the following command:

    app/console

This will display the help of the console, with the available options and
commands.

This file will describe how the console work technically.

## The entry point

The `app/console` file is a simple PHP script with 4 simple steps.

### Getting Composer's autoload

The `require` line calls the autoloader, which job is to include automatically
the project files and load their classes.

You shouldn't concern yourself too much about it.

### Creation of a colorful output

The creation of the `ConsoleOutput` object allows us to print colorful text.

### Checking of the PHP version

If the user uses an unsupported version of PHP, the `version_compare` section
will print a warning.

### Creation of the version extractor

The `VersionExtractor` is a convenient class that retrieves the project version
from the [VERSION.md](../VERSION.md) file.

The current version is mentioned in the following files:
* [the configuration file](../app/config/parameters.yml.dist);
* [the help command test fixture](../tests/Gnugat/Tests/Fixtures/run_help.txt);
* [the application](../src/Gnugat/SoulMeMaybe/Application.php), so it can be
  passed to the help command.

### Creation and launch of the application

Instantiating a new `Application` object will set:

* the name of the project;
* the current version of the project;
* the available commands (`getDefaultCommands` is called in the parent constructor);
* the available options (`getDefaultInputDefinition` is called in the parent constructor).

Calling the `run` method will:

* call the `doRun` method:
  * manage the options of the application;
  * set the help command as the default behavior;
  * run the command.
* exit with the proper code.
