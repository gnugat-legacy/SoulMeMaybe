# Console

To use **SoulMeMaybe**, just run the console with the following command:

    app/console

This will display the help of the console, with the available options and
commands.

This file will describe how the console work technically.

## The entry point

The `app/console` file is a simple PHP script which will get composer's
autoloader, instantiate a new `Application` and run it.

## The `Application`

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
