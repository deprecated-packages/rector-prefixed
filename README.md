# Prefixed Rector

[![Build Status Github Actions](https://img.shields.io/github/workflow/status/rectorphp/rector-prefixed/Code_Checks?style=flat-square)](https://github.com/rectorphp/rector-prefixed/actions)
[![Downloads](https://img.shields.io/packagist/dt/rector/rector-prefixed.svg?style=flat-square)](https://packagist.org/packages/rector/rector-prefixed)

Prefixed version of Rector compiled in PHAR with [compiler](https://github.com/rectorphp/rector/tree/master/compiler).

## 1. With Composer

```bash
composer require rector/rector-prefixed --dev
```

```bash
# generate "rector.php" config
vendor/bin/rector init

# dry run
vendor/bin/rector process src --dry-run

# changing run
vendor/bin/rector process src
```


## 2. Standalone

```bash
wget https://github.com/rectorphp/rector-prefixed/raw/master/rector.phar
chmod +x rector.phar
```

```bash
# generate "rector.php" config
vendor/bin/rector.phar init

# dry run
vendor/bin/rector.phar process src --dry-run

# changing run
vendor/bin/rector.phar process src
```
