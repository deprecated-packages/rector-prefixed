<?php

declare (strict_types=1);
namespace RectorPrefix20210119;

use Rector\Composer\Rector\AddPackageToRequireDevRector;
use Rector\Composer\ValueObject\PackageAndVersion;
use RectorPrefix20210119\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\RectorPrefix20210119\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Composer\Rector\AddPackageToRequireDevRector::class)->call('configure', [[\Rector\Composer\Rector\AddPackageToRequireDevRector::PACKAGES_AND_VERSIONS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Composer\ValueObject\PackageAndVersion('vendor1/package3', '^3.0'), new \Rector\Composer\ValueObject\PackageAndVersion('vendor1/package1', '^3.0'), new \Rector\Composer\ValueObject\PackageAndVersion('vendor1/package2', '^3.0')])]]);
};
