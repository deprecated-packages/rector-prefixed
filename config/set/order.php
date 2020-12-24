<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871;

use _PhpScoper0a6b37af0871\Rector\Order\Rector\Class_\OrderClassConstantsByIntegerValueRector;
use _PhpScoper0a6b37af0871\Rector\Order\Rector\Class_\OrderConstantsByVisibilityRector;
use _PhpScoper0a6b37af0871\Rector\Order\Rector\Class_\OrderMethodsByVisibilityRector;
use _PhpScoper0a6b37af0871\Rector\Order\Rector\Class_\OrderPrivateMethodsByUseRector;
use _PhpScoper0a6b37af0871\Rector\Order\Rector\Class_\OrderPropertiesByVisibilityRector;
use _PhpScoper0a6b37af0871\Rector\Order\Rector\Class_\OrderPropertyByComplexityRector;
use _PhpScoper0a6b37af0871\Rector\Order\Rector\Class_\OrderPublicInterfaceMethodRector;
use _PhpScoper0a6b37af0871\Rector\Order\Rector\ClassMethod\OrderConstructorDependenciesByTypeAlphabeticallyRector;
use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper0a6b37af0871\Rector\Order\Rector\Class_\OrderPrivateMethodsByUseRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Order\Rector\Class_\OrderPublicInterfaceMethodRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Order\Rector\Class_\OrderPropertyByComplexityRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Order\Rector\Class_\OrderClassConstantsByIntegerValueRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Order\Rector\ClassMethod\OrderConstructorDependenciesByTypeAlphabeticallyRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Order\Rector\Class_\OrderMethodsByVisibilityRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Order\Rector\Class_\OrderPropertiesByVisibilityRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Order\Rector\Class_\OrderConstantsByVisibilityRector::class);
};
