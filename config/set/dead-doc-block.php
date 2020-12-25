<?php

declare (strict_types=1);
namespace _PhpScoper8b9c402c5f32;

use Rector\DeadDocBlock\Rector\ClassMethod\RemoveUselessParamTagRector;
use Rector\DeadDocBlock\Rector\ClassMethod\RemoveUselessReturnTagRector;
use Rector\DeadDocBlock\Rector\Node\RemoveNonExistingVarAnnotationRector;
use _PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\DeadDocBlock\Rector\ClassMethod\RemoveUselessParamTagRector::class);
    $services->set(\Rector\DeadDocBlock\Rector\ClassMethod\RemoveUselessReturnTagRector::class);
    $services->set(\Rector\DeadDocBlock\Rector\Node\RemoveNonExistingVarAnnotationRector::class);
};
