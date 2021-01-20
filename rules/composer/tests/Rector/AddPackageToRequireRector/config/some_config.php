<?php

declare (strict_types=1);
namespace RectorPrefix20210120;

use Rector\Composer\Rector\AddPackageToRequireRector;
use Rector\Composer\ValueObject\PackageAndVersion;
use RectorPrefix20210120\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\RectorPrefix20210120\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Composer\Rector\AddPackageToRequireRector::class)->call('configure', [[\Rector\Composer\Rector\AddPackageToRequireRector::PACKAGES_AND_VERSIONS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Composer\ValueObject\PackageAndVersion('vendor1/package3', '^3.0')])]]);
};
