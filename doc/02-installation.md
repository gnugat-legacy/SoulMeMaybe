# Installation

As described in the `README.md` file, by downloading and executing the script
`bin/install.sh` you can easily install **SoulMeMaybe** with the two following
commands:

    wget https://raw.github.com/gnugat/SoulMeMaybe/develop/bin/install.sh
    sh install.sh

This file will describe how the `bin/install.sh` works.

## 1) Clone the sources

To get **SoulMeMaybe**, you can:

* use composer's command `create-project`;
* download the project from Github as a tarball/zipball;
* clone the sources.

The last option seems to be by far the best as it allows you to run `git pull`
to get new versions.

The `Installing SoulMeMaybe...` section of the script does only 2 things:

1. clone the sources with git;
2. change the working directory to the project one, for its next actions.

## 2) Getting composer

To make sure we don't re-invent the wheel, we use many existing libraries for
**SoulMeMaybe**. These are called dependencies. Composer is a dependency
manager, allowing projects like **SoulMeMaybe** to specify which version of
which library should be use and avoiding to add them to the git repository.

It also provides an autoloading tool allowing to require the dependencies when
they are needed.

This means for you that you need to get composer in order to make
**SoulMeMaybe** work. So the `Installing composer...` section of the script
downloads it in the root directory of the project.

## 3) Getting dependencies

As explained in the previous section, the dependencies are not versioned with
**SoulMeMaybe**, which means that they need to be downloaded.

The `Installing SoulMeMaybe dependencies...` section of the script downloads
them using composer.

Once the download is complete, an event is triggered, calling the
`configurator` command which will ask you your login and password socks in order
to configure the project and make it ready to run.

For more information about this command, check its own documentation.

## 4) Optimization

We previously mentioned that composer is also an autoloader. Autoloading
classes can require some time, in order to find them. The
`Optimizing the autoloading...` section of the script is here to solve this
problem, by making a mapping file of the classes to autoload.

## 5) Ready to use

Once these steps have been done, a new `SoulMeMaybe` directory with a working
project is here. The command described in the last message runs the console
which will print a useful help on how to use it.

If you are in the project directory, all you have to do to run the console is
`app/console`.
