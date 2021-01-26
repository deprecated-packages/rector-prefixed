<?php

declare (strict_types=1);
namespace RectorPrefix20210126;

use Rector\Composer\Rector\MovePackageToRequireComposerRector;
use RectorPrefix20210126\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210126\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Composer\Rector\MovePackageToRequireComposerRector::class)->call('configure', [[\Rector\Composer\Rector\MovePackageToRequireComposerRector::PACKAGE_NAMES => ['vendor1/package1']]]);
};
