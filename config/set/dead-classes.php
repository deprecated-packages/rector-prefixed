<?php

declare (strict_types=1);
namespace _PhpScoperbf340cb0be9d;

use Rector\DeadCode\Rector\Class_\RemoveUnusedClassesRector;
use _PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\DeadCode\Rector\Class_\RemoveUnusedClassesRector::class);
};
