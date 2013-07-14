# Commands

To use a command like `help`, just add the name after the console:

    app/console help

Symfony's Console Component, which is used by **SoulMeMaybe**, will look for
the command with the same beginning, which means that typing `h`, `he`, `hel` or
`help` will all call the `help` command.

This file will describe how the commands work technically.

Each time a command is called, the `execute` method of the `Command` class is
the entry point.

## Help command

The help command needs to access the application to retrieve its available
commands and options. This is what the `getApplication` call is for.

## Configurator

This command is structured like the `client` command: it creates an instance of
of `Configurator\Kernel` and then calls its methods.

## Client

The `Client\Kernel` class needs some dependencies, so the `Client\Command`
provides them:

* the parameters retrieved from the `app/config/parameters.yml` file;
* the output which will be described in the following sub-section.

The kernel itself manages a socket to send and receive the requests and
responses.

### The Output

To inform the user, the kernel uses two types of outputs:

* the standard console output;
* the log files.

Depending on the verbosity level, the messages will be printed or not, but they
will always be logged.
