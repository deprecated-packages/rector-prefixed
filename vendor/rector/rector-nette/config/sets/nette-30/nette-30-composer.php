<?php

declare(strict_types=1);

use Rector\Composer\Rector\ChangePackageVersionComposerRector;
use Rector\Composer\Rector\RemovePackageComposerRector;
use Rector\Composer\Rector\ReplacePackageAndVersionComposerRector;
use Rector\Composer\ValueObject\PackageAndVersion;
use Rector\Composer\ValueObject\ReplacePackageAndVersion;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;

return static function (ContainerConfigurator $containerConfigurator) {
    $services = $containerConfigurator->services();

    $services->set(ChangePackageVersionComposerRector::class)
        ->call('configure', [[
            ChangePackageVersionComposerRector::PACKAGES_AND_VERSIONS => ValueObjectInliner::inline([
                new PackageAndVersion('nette/nette', '^3.0'),
                // https://github.com/nette/nette/blob/v2.4.0/composer.json vs https://github.com/nette/nette/blob/v3.0.0/composer.json
                // older versions have security issues
                new PackageAndVersion('nette/application', '^3.0.6'),
                new PackageAndVersion('nette/bootstrap', '^3.0'),
                new PackageAndVersion('nette/caching', '^3.0'),
                new PackageAndVersion('nette/component-model', '^3.0'),
                new PackageAndVersion('nette/database', '^3.0'),
                new PackageAndVersion('nette/di', '^3.0'),
                new PackageAndVersion('nette/finder', '^2.5'),
                new PackageAndVersion('nette/forms', '^3.0'),
                new PackageAndVersion('nette/http', '^3.0'),
                new PackageAndVersion('nette/mail', '^3.0'),
                new PackageAndVersion('nette/neon', '^3.0'),
                new PackageAndVersion('nette/php-generator', '^3.0'),
                new PackageAndVersion('nette/robot-loader', '^3.0'),
                new PackageAndVersion('nette/safe-stream', '^2.4'),
                new PackageAndVersion('nette/security', '^3.0'),
                new PackageAndVersion('nette/tokenizer', '^3.0'),
                new PackageAndVersion('nette/utils', '^3.0'),
                new PackageAndVersion('latte/latte', '^2.5'),
                new PackageAndVersion('tracy/tracy', '^2.6'),

                // contributte packages
                new PackageAndVersion('contributte/event-dispatcher-extra', '^0.8'),
                new PackageAndVersion('contributte/forms-multiplier', '3.1.x-dev'),
                // other packages
                new PackageAndVersion('radekdostal/nette-datetimepicker', '^3.0'),
            ]),
        ]]);

    $services->set(RemovePackageComposerRector::class)
        ->call('configure', [[
            RemovePackageComposerRector::PACKAGE_NAMES => ['nette/deprecated', 'nette/reflection'],
        ]]);

    $services->set(ReplacePackageAndVersionComposerRector::class)
        ->call('configure', [[
            ReplacePackageAndVersionComposerRector::REPLACE_PACKAGES_AND_VERSIONS => ValueObjectInliner::inline([
                // webchemistry to contributte
                new ReplacePackageAndVersion(
                    'webchemistry/forms-multiplier',
                    'contributte/forms-multiplier',
                    '3.1.x-dev'
                ),
            ]),
        ]]);
};
