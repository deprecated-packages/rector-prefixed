<?php

declare (strict_types=1);
namespace RectorPrefix20210116;

use Rector\Composer\Rector\ChangePackageVersionRector;
use Rector\Composer\ValueObject\PackageAndVersion;
use RectorPrefix20210116\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\RectorPrefix20210116\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Composer\Rector\ChangePackageVersionRector::class)->call('configure', [[\Rector\Composer\Rector\ChangePackageVersionRector::PACKAGES_AND_VERSIONS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Composer\ValueObject\PackageAndVersion('vendor1/package3', '^15.0')])]]);
};
