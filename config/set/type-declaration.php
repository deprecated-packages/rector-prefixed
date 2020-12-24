<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\TypeDeclaration\Rector\ClassMethod\AddArrayParamDocTypeRector;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\Rector\ClassMethod\AddArrayReturnDocTypeRector;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\Rector\Closure\AddClosureReturnTypeRector;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\Rector\FunctionLike\ParamTypeDeclarationRector;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\Rector\FunctionLike\ReturnTypeDeclarationRector;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\Rector\Property\PropertyTypeDeclarationRector;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScopere8e811afab72\Rector\TypeDeclaration\Rector\FunctionLike\ParamTypeDeclarationRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\TypeDeclaration\Rector\FunctionLike\ReturnTypeDeclarationRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\TypeDeclaration\Rector\Property\PropertyTypeDeclarationRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\TypeDeclaration\Rector\Closure\AddClosureReturnTypeRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\TypeDeclaration\Rector\ClassMethod\AddArrayParamDocTypeRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\TypeDeclaration\Rector\ClassMethod\AddArrayReturnDocTypeRector::class);
};
