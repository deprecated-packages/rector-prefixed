<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc;

use _PhpScoper2a4e7ab1ecbc\Rector\Order\Rector\Class_\OrderClassConstantsByIntegerValueRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Order\Rector\Class_\OrderConstantsByVisibilityRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Order\Rector\Class_\OrderMethodsByVisibilityRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Order\Rector\Class_\OrderPrivateMethodsByUseRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Order\Rector\Class_\OrderPropertiesByVisibilityRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Order\Rector\Class_\OrderPropertyByComplexityRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Order\Rector\Class_\OrderPublicInterfaceMethodRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Order\Rector\ClassMethod\OrderConstructorDependenciesByTypeAlphabeticallyRector;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Order\Rector\Class_\OrderPrivateMethodsByUseRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Order\Rector\Class_\OrderPublicInterfaceMethodRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Order\Rector\Class_\OrderPropertyByComplexityRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Order\Rector\Class_\OrderClassConstantsByIntegerValueRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Order\Rector\ClassMethod\OrderConstructorDependenciesByTypeAlphabeticallyRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Order\Rector\Class_\OrderMethodsByVisibilityRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Order\Rector\Class_\OrderPropertiesByVisibilityRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Order\Rector\Class_\OrderConstantsByVisibilityRector::class);
};
