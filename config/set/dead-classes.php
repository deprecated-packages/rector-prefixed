<?php

declare (strict_types=1);
namespace RectorPrefix2020DecSat;

use Rector\DeadCode\Rector\Class_\RemoveUnusedClassesRector;
use RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\DeadCode\Rector\Class_\RemoveUnusedClassesRector::class);
};
