<?php

declare (strict_types=1);
namespace _PhpScoperbf340cb0be9d;

use Rector\Order\Rector\Class_\OrderClassConstantsByIntegerValueRector;
use Rector\Order\Rector\Class_\OrderConstantsByVisibilityRector;
use Rector\Order\Rector\Class_\OrderMethodsByVisibilityRector;
use Rector\Order\Rector\Class_\OrderPrivateMethodsByUseRector;
use Rector\Order\Rector\Class_\OrderPropertiesByVisibilityRector;
use Rector\Order\Rector\Class_\OrderPropertyByComplexityRector;
use Rector\Order\Rector\Class_\OrderPublicInterfaceMethodRector;
use Rector\Order\Rector\ClassMethod\OrderConstructorDependenciesByTypeAlphabeticallyRector;
use _PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Order\Rector\Class_\OrderPrivateMethodsByUseRector::class);
    $services->set(\Rector\Order\Rector\Class_\OrderPublicInterfaceMethodRector::class);
    $services->set(\Rector\Order\Rector\Class_\OrderPropertyByComplexityRector::class);
    $services->set(\Rector\Order\Rector\Class_\OrderClassConstantsByIntegerValueRector::class);
    $services->set(\Rector\Order\Rector\ClassMethod\OrderConstructorDependenciesByTypeAlphabeticallyRector::class);
    $services->set(\Rector\Order\Rector\Class_\OrderMethodsByVisibilityRector::class);
    $services->set(\Rector\Order\Rector\Class_\OrderPropertiesByVisibilityRector::class);
    $services->set(\Rector\Order\Rector\Class_\OrderConstantsByVisibilityRector::class);
};
