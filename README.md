# Prefixed Rector

[![Build Status](https://img.shields.io/travis/rectorphp/rector-prefixed/master.svg?style=flat-square)](https://travis-ci.org/rectorphp/rector-prefixed)
[![Downloads](https://img.shields.io/packagist/dt/rector/rector-prefixed.svg?style=flat-square)](https://packagist.org/packages/rector/rector-prefixed)

Prefixed version of Rector compiled in PHAR with [compiler](https://github.com/rectorphp/rector/tree/compiler/compiler).

## Install

```bash
composer require rector/rector-prefixed --dev
```

## Use

```bash
vendor/bin/rector process src --set dead-code --dry-run
```
