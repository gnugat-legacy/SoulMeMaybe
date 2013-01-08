# VERSIONING

This file explains the versioning, branching and API model of this bundle.

## Semantic Versioning

[Semantic Versioning](http://semver.org/) is used. For a X.Y.Z version, we
have:
* fixes or new tests will increase patch number (Z);
* new commands or options will increase minor number (Y);
* removal or name modification of commands and options will increase major number (X).

## Branching Model

The branching model is inspired by this article:
[A successful Git branching model](http://nvie.com/posts/a-successful-git-branching-model/):
* __master__ branch is the main stable one;
*  __develop__ is the main unstable one;
* __hotfix-*__ are used to fix __master__;
* functionality branchs come from __develop__;
* __release-*__ branches are  between __develop__ and __master__.
