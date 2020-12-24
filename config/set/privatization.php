<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\Privatization\Rector\ClassConst\PrivatizeLocalClassConstantRector;
use _PhpScopere8e811afab72\Rector\Privatization\Rector\ClassMethod\PrivatizeFinalClassMethodRector;
use _PhpScopere8e811afab72\Rector\Privatization\Rector\ClassMethod\PrivatizeLocalOnlyMethodRector;
use _PhpScopere8e811afab72\Rector\Privatization\Rector\MethodCall\PrivatizeLocalGetterToPropertyRector;
use _PhpScopere8e811afab72\Rector\Privatization\Rector\Property\PrivatizeFinalClassPropertyRector;
use _PhpScopere8e811afab72\Rector\Privatization\Rector\Property\PrivatizeLocalPropertyToPrivatePropertyRector;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScopere8e811afab72\Rector\Privatization\Rector\ClassMethod\PrivatizeLocalOnlyMethodRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Privatization\Rector\MethodCall\PrivatizeLocalGetterToPropertyRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Privatization\Rector\Property\PrivatizeLocalPropertyToPrivatePropertyRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Privatization\Rector\ClassConst\PrivatizeLocalClassConstantRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Privatization\Rector\Property\PrivatizeFinalClassPropertyRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Privatization\Rector\ClassMethod\PrivatizeFinalClassMethodRector::class);
};
