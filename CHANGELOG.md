# CHANGELOG

This file logs the changes between versions.

## 2.1.1

* Fixed Insight Analysis #15

## 2.1.0

* Added pasword masking support in `configurator`
* Added location support
* Added disconnection
* Fixed rainbow mode using `whatthejeff/fab`
* Fixed server host by using DNS instead of IP
* Added version management in the configuration file for install and update scripts
* Updated `symfony/yaml` and `symfony/console` from 2.1 to 2.3
* Updated `monolog/monolog` from 1.3 to latest of version 1

## 2.0.1

* Fixed `configurator` failure caused by missing dependencies

## 2.0.0

* Added rainbow mode
* Added install and update scripts
* Added support of verbosity level management
* Added support for logging the output
* Changed from script to console with commands (use of `Symfony/Console` component)
* Changed `app/SoulMeMaybe.php` to `app/console`

## 1.1.4

* Fixed verification of the configuration file presence
* Fixed `StateRequest` class name
* Fixed version number

## 1.1.3 (released after 1.0.2)

* Fixed user's state with the addition of `StateRequest`

## 1.1.2

* Updated `symfony/Yaml` component from 2.0 to 2.1
* Fixed `PingResponse` failure by checking `fgets` return value

## 1.1.1

* Fixed `configurator` by using a value different from the key in the default configuration

## 1.1.0 (released after 1.0.1)

* Fixed PHP warning on connection failure
* Fixed ping message by removing line endings
* Added `configurator` command to allow auto-configuration via Composer's events

## 1.0.3 (released after 1.1.4)

* Updated `symfony/Yaml` component from 2.0 to 2.1
* Fixed verification of the configuration file presence
* Fixed `StateRequest` class name

## 1.0.2 (released during the development of 2.0.0)

* Fixed user's state with the addition of `StateRequest`

## 1.0.1

* Fixed composer package name
