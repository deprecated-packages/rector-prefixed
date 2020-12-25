<?php

declare (strict_types=1);
namespace _PhpScoper8b9c402c5f32;

use Rector\TypeDeclaration\Rector\ClassMethod\AddArrayParamDocTypeRector;
use Rector\TypeDeclaration\Rector\ClassMethod\AddArrayReturnDocTypeRector;
use Rector\TypeDeclaration\Rector\Closure\AddClosureReturnTypeRector;
use Rector\TypeDeclaration\Rector\FunctionLike\ParamTypeDeclarationRector;
use Rector\TypeDeclaration\Rector\FunctionLike\ReturnTypeDeclarationRector;
use Rector\TypeDeclaration\Rector\Property\PropertyTypeDeclarationRector;
use _PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\TypeDeclaration\Rector\FunctionLike\ParamTypeDeclarationRector::class);
    $services->set(\Rector\TypeDeclaration\Rector\FunctionLike\ReturnTypeDeclarationRector::class);
    $services->set(\Rector\TypeDeclaration\Rector\Property\PropertyTypeDeclarationRector::class);
    $services->set(\Rector\TypeDeclaration\Rector\Closure\AddClosureReturnTypeRector::class);
    $services->set(\Rector\TypeDeclaration\Rector\ClassMethod\AddArrayParamDocTypeRector::class);
    $services->set(\Rector\TypeDeclaration\Rector\ClassMethod\AddArrayReturnDocTypeRector::class);
};
