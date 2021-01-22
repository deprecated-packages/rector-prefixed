<?php

declare (strict_types=1);
namespace RectorPrefix20210122;

use Rector\Composer\Rector\RemovePackageRector;
use RectorPrefix20210122\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210122\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Composer\Rector\RemovePackageRector::class)->call('configure', [[\Rector\Composer\Rector\RemovePackageRector::PACKAGE_NAMES => ['vendor1/package3', 'vendor1/package1', 'vendor1/package2']]]);
};
