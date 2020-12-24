<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\Doctrine\Rector\Class_\ManagerRegistryGetManagerToEntityManagerRector;
use _PhpScopere8e811afab72\Rector\DoctrineCodeQuality\Rector\Class_\InitializeDefaultEntityCollectionRector;
use _PhpScopere8e811afab72\Rector\DoctrineCodeQuality\Rector\Class_\MoveCurrentDateTimeDefaultInEntityToConstructorRector;
use _PhpScopere8e811afab72\Rector\DoctrineCodeQuality\Rector\Class_\RemoveRedundantDefaultClassAnnotationValuesRector;
use _PhpScopere8e811afab72\Rector\DoctrineCodeQuality\Rector\ClassMethod\MakeEntityDateTimePropertyDateTimeInterfaceRector;
use _PhpScopere8e811afab72\Rector\DoctrineCodeQuality\Rector\ClassMethod\MakeEntitySetterNullabilityInSyncWithPropertyRector;
use _PhpScopere8e811afab72\Rector\DoctrineCodeQuality\Rector\Property\ChangeBigIntEntityPropertyToIntTypeRector;
use _PhpScopere8e811afab72\Rector\DoctrineCodeQuality\Rector\Property\CorrectDefaultTypesOnEntityPropertyRector;
use _PhpScopere8e811afab72\Rector\DoctrineCodeQuality\Rector\Property\ImproveDoctrineCollectionDocTypeInEntityRector;
use _PhpScopere8e811afab72\Rector\DoctrineCodeQuality\Rector\Property\RemoveRedundantDefaultPropertyAnnotationValuesRector;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScopere8e811afab72\Rector\Doctrine\Rector\Class_\ManagerRegistryGetManagerToEntityManagerRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\DoctrineCodeQuality\Rector\Class_\InitializeDefaultEntityCollectionRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\DoctrineCodeQuality\Rector\ClassMethod\MakeEntitySetterNullabilityInSyncWithPropertyRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\DoctrineCodeQuality\Rector\ClassMethod\MakeEntityDateTimePropertyDateTimeInterfaceRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\DoctrineCodeQuality\Rector\Class_\MoveCurrentDateTimeDefaultInEntityToConstructorRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\DoctrineCodeQuality\Rector\Property\CorrectDefaultTypesOnEntityPropertyRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\DoctrineCodeQuality\Rector\Property\ChangeBigIntEntityPropertyToIntTypeRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\DoctrineCodeQuality\Rector\Property\ImproveDoctrineCollectionDocTypeInEntityRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\DoctrineCodeQuality\Rector\Property\RemoveRedundantDefaultPropertyAnnotationValuesRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\DoctrineCodeQuality\Rector\Class_\RemoveRedundantDefaultClassAnnotationValuesRector::class);
};
