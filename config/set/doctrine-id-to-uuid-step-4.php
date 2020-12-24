<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\Doctrine\Rector\ClassMethod\ChangeGetIdTypeToUuidRector;
use _PhpScopere8e811afab72\Rector\Doctrine\Rector\ClassMethod\ChangeSetIdTypeToUuidRector;
use _PhpScopere8e811afab72\Rector\Doctrine\Rector\Property\AddUuidAnnotationsToIdPropertyRector;
use _PhpScopere8e811afab72\Rector\Doctrine\Rector\Property\RemoveTemporaryUuidColumnPropertyRector;
use _PhpScopere8e811afab72\Rector\Doctrine\Rector\Property\RemoveTemporaryUuidRelationPropertyRector;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    # properties
    $services->set(\_PhpScopere8e811afab72\Rector\Doctrine\Rector\Property\AddUuidAnnotationsToIdPropertyRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Doctrine\Rector\Property\RemoveTemporaryUuidColumnPropertyRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Doctrine\Rector\Property\RemoveTemporaryUuidRelationPropertyRector::class);
    # methods
    $services->set(\_PhpScopere8e811afab72\Rector\Doctrine\Rector\ClassMethod\ChangeGetIdTypeToUuidRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Doctrine\Rector\ClassMethod\ChangeSetIdTypeToUuidRector::class);
};
