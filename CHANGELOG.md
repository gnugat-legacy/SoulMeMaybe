# CHANGELOG

This file logs the changes between versions.

## 2.0.1

* Fixing the configuration error on install.

## 2.0.0

* Adding a rainbow mode;
* a begining of tests for the output and the application;
* install and update scripts;
* possibility to manage the verbosity level;
* logging the output;
* creating complete doc on installation, update, console commands and NetSoul implementation;
* improving the `README.md`;
* adding a `CONTRIBUTION.md` file to help contributors;
* change from script to console with commands (use of `Symfony/Console` component):
  * `help`: the default one, printing the list of available commands;
  * `configurator`: helps to configure the project;
  * `client`: connects to the NetSoul and provide internet access.
* moving `app/SoulMeMaybe.php` to `app/console`.

## 1.1.4

* fixing the v1.1.3 crash;
* fixing the version number;
* checking the presence of the configuration file.

## 1.1.3

* Adding the state request.

## 1.1.2

* Fixing the ping response;
* improving documentation;
* updating dependencies.

## 1.1.1

* Fixing the configurator.

## 1.1.0

* Adding the installation via composer;
* adding the configurator on post-install composer's event;
* fixing the ping request message;
* hiding PHP warning on connection fail.

## v1.0.3

* fixing the v1.0.2 crash;
* updating the symfony/Yaml component.

## v1.0.2

* adding the state request.

## v1.0.3

* fixing the v1.0.2 crash;
* updating the symfony/Yaml component.

## v1.0.2

* adding the state request.

## v1.0.1

* fixing the composer package name.
