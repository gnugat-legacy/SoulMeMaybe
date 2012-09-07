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

As SoulMeMaybe uses [Composer](http://getcomposer.org/) to manage its
dependencies, the recommended way to install it is to use it.

If you don't have Composer yet, download it following the instructions on
http://getcomposer.org/ or just run the following command:

    curl -s http://getcomposer.org/installer | php

Then, use the `create-project` command to get the dependencies:

    php composer.phar create-project gnugat/soul-me-maybe

Composer will install SoulMeMaybe under the `soul-me-maybe` directory and
will ask you your login and password socks to create the configuration into
the `app/config/parameters.yml` file.

# Documentation

You can find more documentation at the following links:

* Copyright and MIT license: ``./LICENSE.md``;
* version and change log: ``./VERSION.md`` and ``CHANGELOG.md``;
* versioning, branch and public API models: ``./VERSIONING.md``;
* more documentation: see `./doc/01-index.md`.

# Contributing

1. [Fork it](https://github.com/gnugat/SoulMeMaybe/fork_select) ;
2. create a branch (``git checkout -b my_branch``);
3. commit your changes (``git commit -am "Changes description message"``);
4. push to the branch (``git push origin my_branch``);
5. create a pull request with a description of what have been done;
6. wait for it to be accepted/argued.
