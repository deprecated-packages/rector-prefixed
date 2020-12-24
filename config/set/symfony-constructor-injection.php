<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\Symfony\Rector\MethodCall\GetParameterToConstructorInjectionRector;
use _PhpScopere8e811afab72\Rector\Symfony\Rector\MethodCall\GetToConstructorInjectionRector;
use _PhpScopere8e811afab72\Rector\Symfony4\Rector\MethodCall\ContainerGetToConstructorInjectionRector;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScopere8e811afab72\Rector\Symfony4\Rector\MethodCall\ContainerGetToConstructorInjectionRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Symfony\Rector\MethodCall\GetParameterToConstructorInjectionRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Symfony\Rector\MethodCall\GetToConstructorInjectionRector::class);
};
