# SoulMeMaybe, NetSoul client

> Hey, I just met EPITECH,
>
> And this is crazy,
>
> But here's my NetSoul client,
>
> So soul me, maybe?

NetSoul is a protocol used in EPITECH university allowing its students to:

* use internet;
* locate each others;
* send instant messages.

**SoulMeMaybe** is a simple client for NetSoul, sending ping requests so
internet can be accessed (localization and IM won't be implemented).

# Installation

To quickly and easily install **SoulMeMaybe**, download
[Composer](http://getcomposer.org/) and run its `create-project` as in the
following commands:

    curl -s http://getcomposer.org/installer | php
    php composer.phar create-project gnugat/soul-me-maybe

Composer will install **SoulMeMaybe** under the `soul-me-maybe` directory and
will ask you your login and password socks to create the configuration into
the `./config/parameters.yml` file.

You can then run the project with the following command:

    php ./soul-me-maybe/app/SoulMeMaybe.php

# Further documentation

You can find more documentation at the following links:

* Copyright and MIT license: `./LICENSE.md`;
* version and change log: `./VERSION.md`` and `CHANGELOG.md`;
* versioning, branch and public API models: `./VERSIONING.md`;
* contributing: `./CONTRIBUTING.md`;
* more documentation: see `./doc/01-index.md`.
