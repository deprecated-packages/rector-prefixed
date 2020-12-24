<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871;

use _PhpScoper0a6b37af0871\Rector\Doctrine\Rector\Class_\ManagerRegistryGetManagerToEntityManagerRector;
use _PhpScoper0a6b37af0871\Rector\DoctrineCodeQuality\Rector\Class_\InitializeDefaultEntityCollectionRector;
use _PhpScoper0a6b37af0871\Rector\DoctrineCodeQuality\Rector\Class_\MoveCurrentDateTimeDefaultInEntityToConstructorRector;
use _PhpScoper0a6b37af0871\Rector\DoctrineCodeQuality\Rector\Class_\RemoveRedundantDefaultClassAnnotationValuesRector;
use _PhpScoper0a6b37af0871\Rector\DoctrineCodeQuality\Rector\ClassMethod\MakeEntityDateTimePropertyDateTimeInterfaceRector;
use _PhpScoper0a6b37af0871\Rector\DoctrineCodeQuality\Rector\ClassMethod\MakeEntitySetterNullabilityInSyncWithPropertyRector;
use _PhpScoper0a6b37af0871\Rector\DoctrineCodeQuality\Rector\Property\ChangeBigIntEntityPropertyToIntTypeRector;
use _PhpScoper0a6b37af0871\Rector\DoctrineCodeQuality\Rector\Property\CorrectDefaultTypesOnEntityPropertyRector;
use _PhpScoper0a6b37af0871\Rector\DoctrineCodeQuality\Rector\Property\ImproveDoctrineCollectionDocTypeInEntityRector;
use _PhpScoper0a6b37af0871\Rector\DoctrineCodeQuality\Rector\Property\RemoveRedundantDefaultPropertyAnnotationValuesRector;
use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper0a6b37af0871\Rector\Doctrine\Rector\Class_\ManagerRegistryGetManagerToEntityManagerRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\DoctrineCodeQuality\Rector\Class_\InitializeDefaultEntityCollectionRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\DoctrineCodeQuality\Rector\ClassMethod\MakeEntitySetterNullabilityInSyncWithPropertyRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\DoctrineCodeQuality\Rector\ClassMethod\MakeEntityDateTimePropertyDateTimeInterfaceRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\DoctrineCodeQuality\Rector\Class_\MoveCurrentDateTimeDefaultInEntityToConstructorRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\DoctrineCodeQuality\Rector\Property\CorrectDefaultTypesOnEntityPropertyRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\DoctrineCodeQuality\Rector\Property\ChangeBigIntEntityPropertyToIntTypeRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\DoctrineCodeQuality\Rector\Property\ImproveDoctrineCollectionDocTypeInEntityRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\DoctrineCodeQuality\Rector\Property\RemoveRedundantDefaultPropertyAnnotationValuesRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\DoctrineCodeQuality\Rector\Class_\RemoveRedundantDefaultClassAnnotationValuesRector::class);
};
