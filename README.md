# Prefixed Rector

[![Build Status Github Actions](https://img.shields.io/github/workflow/status/rectorphp/rector-prefixed/Code_Checks?style=flat-square)](https://github.com/rectorphp/rector-prefixed/actions)
[![Downloads](https://img.shields.io/packagist/dt/rector/rector-prefixed.svg?style=flat-square)](https://packagist.org/packages/rector/rector-prefixed)

Prefixed version of Rector compiled in PHAR with [compiler](https://github.com/rectorphp/rector/tree/master/compiler).

## Install

```bash
composer require rector/rector-prefixed --dev
```

## Use

```bash
vendor/bin/rector process src --set dead-code --dry-run
```
