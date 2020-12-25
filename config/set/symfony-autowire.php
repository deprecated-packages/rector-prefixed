<?php

declare (strict_types=1);
namespace _PhpScoperbf340cb0be9d;

use Rector\Symfony\Rector\ClassMethod\AutoWireWithClassNameSuffixForMethodWithRequiredAnnotationRector;
use _PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Symfony\Rector\ClassMethod\AutoWireWithClassNameSuffixForMethodWithRequiredAnnotationRector::class);
};
