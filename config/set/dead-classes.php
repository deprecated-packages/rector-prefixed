<?php

declare (strict_types=1);
namespace RectorPrefix20201229;

use Rector\DeadCode\Rector\Class_\RemoveUnusedClassesRector;
use RectorPrefix20201229\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20201229\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\DeadCode\Rector\Class_\RemoveUnusedClassesRector::class);
};
