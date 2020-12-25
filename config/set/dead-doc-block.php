<?php

declare (strict_types=1);
namespace _PhpScoperbf340cb0be9d;

use Rector\DeadDocBlock\Rector\ClassMethod\RemoveUselessParamTagRector;
use Rector\DeadDocBlock\Rector\ClassMethod\RemoveUselessReturnTagRector;
use Rector\DeadDocBlock\Rector\Node\RemoveNonExistingVarAnnotationRector;
use _PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\DeadDocBlock\Rector\ClassMethod\RemoveUselessParamTagRector::class);
    $services->set(\Rector\DeadDocBlock\Rector\ClassMethod\RemoveUselessReturnTagRector::class);
    $services->set(\Rector\DeadDocBlock\Rector\Node\RemoveNonExistingVarAnnotationRector::class);
};
