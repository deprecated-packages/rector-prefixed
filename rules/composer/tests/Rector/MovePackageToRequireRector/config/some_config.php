<?php

declare (strict_types=1);
namespace RectorPrefix20210118;

use Rector\Composer\Rector\MovePackageToRequireRector;
use RectorPrefix20210118\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210118\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Composer\Rector\MovePackageToRequireRector::class)->call('configure', [[\Rector\Composer\Rector\MovePackageToRequireRector::PACKAGE_NAMES => ['vendor1/package1']]]);
};
