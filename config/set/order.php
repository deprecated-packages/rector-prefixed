<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\Order\Rector\Class_\OrderClassConstantsByIntegerValueRector;
use _PhpScopere8e811afab72\Rector\Order\Rector\Class_\OrderConstantsByVisibilityRector;
use _PhpScopere8e811afab72\Rector\Order\Rector\Class_\OrderMethodsByVisibilityRector;
use _PhpScopere8e811afab72\Rector\Order\Rector\Class_\OrderPrivateMethodsByUseRector;
use _PhpScopere8e811afab72\Rector\Order\Rector\Class_\OrderPropertiesByVisibilityRector;
use _PhpScopere8e811afab72\Rector\Order\Rector\Class_\OrderPropertyByComplexityRector;
use _PhpScopere8e811afab72\Rector\Order\Rector\Class_\OrderPublicInterfaceMethodRector;
use _PhpScopere8e811afab72\Rector\Order\Rector\ClassMethod\OrderConstructorDependenciesByTypeAlphabeticallyRector;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScopere8e811afab72\Rector\Order\Rector\Class_\OrderPrivateMethodsByUseRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Order\Rector\Class_\OrderPublicInterfaceMethodRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Order\Rector\Class_\OrderPropertyByComplexityRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Order\Rector\Class_\OrderClassConstantsByIntegerValueRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Order\Rector\ClassMethod\OrderConstructorDependenciesByTypeAlphabeticallyRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Order\Rector\Class_\OrderMethodsByVisibilityRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Order\Rector\Class_\OrderPropertiesByVisibilityRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Order\Rector\Class_\OrderConstantsByVisibilityRector::class);
};
