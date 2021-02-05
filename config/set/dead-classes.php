<?php

declare (strict_types=1);
namespace RectorPrefix20210205;

use Rector\DeadCode\Rector\Class_\RemoveUnusedClassesRector;
use Rector\DeadCode\Rector\Class_\RemoveUselessJustForSakeInterfaceRector;
use RectorPrefix20210205\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210205\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\DeadCode\Rector\Class_\RemoveUnusedClassesRector::class);
    $services->set(\Rector\DeadCode\Rector\Class_\RemoveUselessJustForSakeInterfaceRector::class);
};
