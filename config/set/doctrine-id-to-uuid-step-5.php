<?php

declare (strict_types=1);
namespace RectorPrefix20210125;

use Rector\Doctrine\Rector\ClassMethod\ChangeReturnTypeOfClassMethodWithGetIdRector;
use Rector\Doctrine\Rector\Identical\ChangeIdenticalUuidToEqualsMethodCallRector;
use Rector\Doctrine\Rector\MethodCall\ChangeGetUuidMethodCallToGetIdRector;
use Rector\Doctrine\Rector\MethodCall\ChangeSetIdToUuidValueRector;
use Rector\TypeDeclaration\Rector\ClassMethod\AddArrayReturnDocTypeRector;
use Rector\TypeDeclaration\Rector\ClassMethod\AddMethodCallBasedParamTypeRector;
use RectorPrefix20210125\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210125\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Doctrine\Rector\MethodCall\ChangeSetIdToUuidValueRector::class);
    $services->set(\Rector\Doctrine\Rector\MethodCall\ChangeGetUuidMethodCallToGetIdRector::class);
    $services->set(\Rector\Doctrine\Rector\ClassMethod\ChangeReturnTypeOfClassMethodWithGetIdRector::class);
    $services->set(\Rector\Doctrine\Rector\Identical\ChangeIdenticalUuidToEqualsMethodCallRector::class);
    # add Uuid type declarations
    $services->set(\Rector\TypeDeclaration\Rector\ClassMethod\AddMethodCallBasedParamTypeRector::class);
    $services->set(\Rector\TypeDeclaration\Rector\ClassMethod\AddArrayReturnDocTypeRector::class);
};
