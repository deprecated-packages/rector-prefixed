# Rule Doc Generator

Generate Documentation for you Sniffer, Fixer, Rector, PHPStan... any rule in nice styled Markdown syntax with PHP Code examples everyone will understand.

[![Downloads total](https://img.shields.io/packagist/dt/symplify/rule-doc-generator.svg?style=flat-square)](https://packagist.org/packages/symplify/rule-doc-generator/stats)

## Install

```bash
composer require symplify/rule-doc-generator --dev
```

## Usage

To generate documentation from rules, use `generate` command with paths that contain the rules:

```bash
vendor/bin/rule-doc-generator generate src/Rules
```

The file will be generated to `/docs/rules_overview.md` by default. To change that, use `--output-file`:

```bash
vendor/bin/rule-doc-generator generate src/Rules --output-file docs/symplify_rules.md
```

Happy coding!

<br>

## Report Issues

In case you are experiencing a bug or want to request a new feature head over to the [Symplify monorepo issue tracker](https://github.com/symplify/symplify/issues)

## Contribute

The sources of this package are contained in the Symplify monorepo. We welcome contributions for this package on [symplify/symplify](https://github.com/symplify/symplify).
