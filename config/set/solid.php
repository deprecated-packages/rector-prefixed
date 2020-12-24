<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\CodingStyle\Rector\MethodCall\UseMessageVariableForSprintfInSymfonyStyleRector;
use _PhpScopere8e811afab72\Rector\SOLID\Rector\Class_\ChangeReadOnlyVariableWithDefaultValueToConstantRector;
use _PhpScopere8e811afab72\Rector\SOLID\Rector\Class_\FinalizeClassesWithoutChildrenRector;
use _PhpScopere8e811afab72\Rector\SOLID\Rector\Class_\MakeUnusedClassesWithChildrenAbstractRector;
use _PhpScopere8e811afab72\Rector\SOLID\Rector\Class_\RepeatedLiteralToClassConstantRector;
use _PhpScopere8e811afab72\Rector\SOLID\Rector\Property\AddFalseDefaultToBoolPropertyRector;
use _PhpScopere8e811afab72\Rector\SOLID\Rector\Property\ChangeReadOnlyPropertyWithDefaultValueToConstantRector;
use _PhpScopere8e811afab72\Rector\SOLID\Rector\Variable\MoveVariableDeclarationNearReferenceRector;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScopere8e811afab72\Rector\SOLID\Rector\Class_\FinalizeClassesWithoutChildrenRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\SOLID\Rector\Class_\MakeUnusedClassesWithChildrenAbstractRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\SOLID\Rector\Property\ChangeReadOnlyPropertyWithDefaultValueToConstantRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\SOLID\Rector\Class_\ChangeReadOnlyVariableWithDefaultValueToConstantRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\SOLID\Rector\Property\AddFalseDefaultToBoolPropertyRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\SOLID\Rector\Class_\RepeatedLiteralToClassConstantRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\CodingStyle\Rector\MethodCall\UseMessageVariableForSprintfInSymfonyStyleRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\SOLID\Rector\Variable\MoveVariableDeclarationNearReferenceRector::class);
};
