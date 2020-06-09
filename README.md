# Prefixed Rector

[![Build Status Github Actions](https://img.shields.io/github/workflow/status/rectorphp/rector-prefixed/Code_Checks?style=flat-square)](https://github.com/rectorphp/rector-prefixed/actions)
[![Downloads](https://img.shields.io/packagist/dt/rector/rector-prefixed.svg?style=flat-square)](https://packagist.org/packages/rector/rector-prefixed)

Prefixed version of Rector compiled in PHAR with [compiler](https://github.com/rectorphp/rector/tree/master/compiler).

## 1. With Composer

```bash
composer require rector/rector-prefixed --dev
```

```bash
vendor/bin/rector process src --set dead-code --dry-run
```


## 2. Standalone

```bash
wget https://github.com/rectorphp/rector-prefixed/raw/master/rector.phar
chmod +x rector.phar
```

```bash
rector.phar process src --set dead-code --dry-run
```
