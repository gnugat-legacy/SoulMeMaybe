# VERSIONING

This file explains the versioning and, branching models of this project.

## Semantic Versioning

[Semantic Versioning](http://semver.org/) is used. For a version X.Y.Z, we have:
* removal or name modification of commands and options will increase major number (X);
* new commands or options will increase minor number (Y);
* fixes or new tests will increase patch number (Z).

## Branching Model

The branching model is inspired by this article:
[A successful Git branching model](http://nvie.com/posts/a-successful-git-branching-model/):
* __master__ branch is the main stable one;
*  __develop__ is the main unstable one;
* __hotfix/*__ are used to fix __master__;
* __release/*__ branches are  between __develop__ and __master__;
* the other branches come from __develop__:
  * __feature/*__ for new functionalities;
  * __test/*__ for new tests;
  * __fix/*__ to fix bugs only present in __develop__;
  * __refactoring/*__ for refactorings.
