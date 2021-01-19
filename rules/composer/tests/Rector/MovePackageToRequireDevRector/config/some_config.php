<?php

declare (strict_types=1);
namespace RectorPrefix20210119;

use Rector\Composer\Rector\MovePackageToRequireDevRector;
use RectorPrefix20210119\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210119\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Composer\Rector\MovePackageToRequireDevRector::class)->call('configure', [[\Rector\Composer\Rector\MovePackageToRequireDevRector::PACKAGE_NAMES => ['vendor1/package3']]]);
};
