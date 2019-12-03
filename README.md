# Prefixed Rector (WIP)

[![Build Status](https://img.shields.io/travis/rectorphp/rector-prefixed/master.svg?style=flat-square)](https://travis-ci.org/rectorphp/rector-prefixed)
[![Coverage Status](https://img.shields.io/coveralls/rectorphp/rector-prefixed/master.svg?style=flat-square)](https://coveralls.io/github/rectorphp/rector-prefixed?branch=master)
[![Downloads](https://img.shields.io/packagist/dt/rector/rector.svg?style=flat-square)](https://packagist.org/packages/rector/rector)

Prefixed version of Rector compiled in PHAR with [compiler](https://github.com/rectorphp/rector/tree/compiler/compiler).

## Install

```bash
composer require retor/rector-prefixed --dev
```

## Use

```bash
vendor/bin/rector-prefixed process src --set dead-code --dry-run
```
