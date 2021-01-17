<?php

declare (strict_types=1);
namespace RectorPrefix20210117;

use Rector\Composer\Rector\ChangePackageVersionRector;
use Rector\Composer\Rector\MovePackageToRequireDevRector;
use Rector\Composer\Rector\ReplacePackageAndVersionRector;
use Rector\Composer\ValueObject\PackageAndVersion;
use Rector\Composer\ValueObject\ReplacePackageAndVersion;
use RectorPrefix20210117\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\RectorPrefix20210117\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Composer\Rector\MovePackageToRequireDevRector::class)->call('configure', [[\Rector\Composer\Rector\MovePackageToRequireDevRector::PACKAGE_NAMES => ['vendor1/package1']]]);
    $services->set(\Rector\Composer\Rector\ReplacePackageAndVersionRector::class)->call('configure', [[\Rector\Composer\Rector\ReplacePackageAndVersionRector::REPLACE_PACKAGES_AND_VERSIONS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Composer\ValueObject\ReplacePackageAndVersion('vendor1/package2', 'vendor2/package1', '^3.0')])]]);
    $services->set(\Rector\Composer\Rector\ChangePackageVersionRector::class)->call('configure', [[\Rector\Composer\Rector\ChangePackageVersionRector::PACKAGES_AND_VERSIONS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Composer\ValueObject\PackageAndVersion('vendor1/package3', '~3.0.0')])]]);
};
