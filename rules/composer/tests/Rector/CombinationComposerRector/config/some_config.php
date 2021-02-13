<?php

declare (strict_types=1);
namespace RectorPrefix20210213;

use Rector\Composer\Rector\ChangePackageVersionComposerRector;
use Rector\Composer\Rector\ReplacePackageAndVersionComposerRector;
use Rector\Composer\ValueObject\PackageAndVersion;
use Rector\Composer\ValueObject\ReplacePackageAndVersion;
use RectorPrefix20210213\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\RectorPrefix20210213\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Composer\Rector\ReplacePackageAndVersionComposerRector::class)->call('configure', [[\Rector\Composer\Rector\ReplacePackageAndVersionComposerRector::REPLACE_PACKAGES_AND_VERSIONS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Composer\ValueObject\ReplacePackageAndVersion('vendor1/package2', 'vendor2/package1', '^3.0')])]]);
    $services->set(\Rector\Composer\Rector\ChangePackageVersionComposerRector::class)->call('configure', [[\Rector\Composer\Rector\ChangePackageVersionComposerRector::PACKAGES_AND_VERSIONS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Composer\ValueObject\PackageAndVersion('vendor1/package3', '~3.0.0')])]]);
};
