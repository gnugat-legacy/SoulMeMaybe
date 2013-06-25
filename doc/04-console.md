# Console

To use **SoulMeMaybe**, just run the console with the following command:

    app/console

This will display the help of the console, with the available options and
commands.

This file will describe how the console work technically.

## The entry point

The `app/console` file is a simple PHP script with 3 simple steps.

### Getting Composer's autoload

The `require` line calls the autoloader, which job is to include automatically
the project files.

You shouldn't concern yourself too much about it.

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

* set the input and a colorful output;
* call the `doRun` method:
  * check the PHP version;
  * manage the options of the application;
  * sets the help command as the default behavior;
  * runs the command.
* exits with the proper code.
