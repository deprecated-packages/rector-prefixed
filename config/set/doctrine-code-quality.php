<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\Rector\Doctrine\Rector\Class_\ManagerRegistryGetManagerToEntityManagerRector;
use _PhpScoperb75b35f52b74\Rector\DoctrineCodeQuality\Rector\Class_\InitializeDefaultEntityCollectionRector;
use _PhpScoperb75b35f52b74\Rector\DoctrineCodeQuality\Rector\Class_\MoveCurrentDateTimeDefaultInEntityToConstructorRector;
use _PhpScoperb75b35f52b74\Rector\DoctrineCodeQuality\Rector\Class_\RemoveRedundantDefaultClassAnnotationValuesRector;
use _PhpScoperb75b35f52b74\Rector\DoctrineCodeQuality\Rector\ClassMethod\MakeEntityDateTimePropertyDateTimeInterfaceRector;
use _PhpScoperb75b35f52b74\Rector\DoctrineCodeQuality\Rector\ClassMethod\MakeEntitySetterNullabilityInSyncWithPropertyRector;
use _PhpScoperb75b35f52b74\Rector\DoctrineCodeQuality\Rector\Property\ChangeBigIntEntityPropertyToIntTypeRector;
use _PhpScoperb75b35f52b74\Rector\DoctrineCodeQuality\Rector\Property\CorrectDefaultTypesOnEntityPropertyRector;
use _PhpScoperb75b35f52b74\Rector\DoctrineCodeQuality\Rector\Property\ImproveDoctrineCollectionDocTypeInEntityRector;
use _PhpScoperb75b35f52b74\Rector\DoctrineCodeQuality\Rector\Property\RemoveRedundantDefaultPropertyAnnotationValuesRector;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoperb75b35f52b74\Rector\Doctrine\Rector\Class_\ManagerRegistryGetManagerToEntityManagerRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\DoctrineCodeQuality\Rector\Class_\InitializeDefaultEntityCollectionRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\DoctrineCodeQuality\Rector\ClassMethod\MakeEntitySetterNullabilityInSyncWithPropertyRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\DoctrineCodeQuality\Rector\ClassMethod\MakeEntityDateTimePropertyDateTimeInterfaceRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\DoctrineCodeQuality\Rector\Class_\MoveCurrentDateTimeDefaultInEntityToConstructorRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\DoctrineCodeQuality\Rector\Property\CorrectDefaultTypesOnEntityPropertyRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\DoctrineCodeQuality\Rector\Property\ChangeBigIntEntityPropertyToIntTypeRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\DoctrineCodeQuality\Rector\Property\ImproveDoctrineCollectionDocTypeInEntityRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\DoctrineCodeQuality\Rector\Property\RemoveRedundantDefaultPropertyAnnotationValuesRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\DoctrineCodeQuality\Rector\Class_\RemoveRedundantDefaultClassAnnotationValuesRector::class);
};
