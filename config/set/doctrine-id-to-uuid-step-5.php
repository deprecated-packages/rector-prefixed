<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\Doctrine\Rector\ClassMethod\ChangeReturnTypeOfClassMethodWithGetIdRector;
use _PhpScopere8e811afab72\Rector\Doctrine\Rector\Identical\ChangeIdenticalUuidToEqualsMethodCallRector;
use _PhpScopere8e811afab72\Rector\Doctrine\Rector\MethodCall\ChangeGetUuidMethodCallToGetIdRector;
use _PhpScopere8e811afab72\Rector\Doctrine\Rector\MethodCall\ChangeSetIdToUuidValueRector;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\Rector\ClassMethod\AddArrayReturnDocTypeRector;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\Rector\ClassMethod\AddMethodCallBasedParamTypeRector;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScopere8e811afab72\Rector\Doctrine\Rector\MethodCall\ChangeSetIdToUuidValueRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Doctrine\Rector\MethodCall\ChangeGetUuidMethodCallToGetIdRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Doctrine\Rector\ClassMethod\ChangeReturnTypeOfClassMethodWithGetIdRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Doctrine\Rector\Identical\ChangeIdenticalUuidToEqualsMethodCallRector::class);
    # add Uuid type declarations
    $services->set(\_PhpScopere8e811afab72\Rector\TypeDeclaration\Rector\ClassMethod\AddMethodCallBasedParamTypeRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\TypeDeclaration\Rector\ClassMethod\AddArrayReturnDocTypeRector::class);
};
