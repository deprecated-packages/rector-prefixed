<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871;

use _PhpScoper0a6b37af0871\Rector\TypeDeclaration\Rector\ClassMethod\AddArrayParamDocTypeRector;
use _PhpScoper0a6b37af0871\Rector\TypeDeclaration\Rector\ClassMethod\AddArrayReturnDocTypeRector;
use _PhpScoper0a6b37af0871\Rector\TypeDeclaration\Rector\Closure\AddClosureReturnTypeRector;
use _PhpScoper0a6b37af0871\Rector\TypeDeclaration\Rector\FunctionLike\ParamTypeDeclarationRector;
use _PhpScoper0a6b37af0871\Rector\TypeDeclaration\Rector\FunctionLike\ReturnTypeDeclarationRector;
use _PhpScoper0a6b37af0871\Rector\TypeDeclaration\Rector\Property\PropertyTypeDeclarationRector;
use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper0a6b37af0871\Rector\TypeDeclaration\Rector\FunctionLike\ParamTypeDeclarationRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\TypeDeclaration\Rector\FunctionLike\ReturnTypeDeclarationRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\TypeDeclaration\Rector\Property\PropertyTypeDeclarationRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\TypeDeclaration\Rector\Closure\AddClosureReturnTypeRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\TypeDeclaration\Rector\ClassMethod\AddArrayParamDocTypeRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\TypeDeclaration\Rector\ClassMethod\AddArrayReturnDocTypeRector::class);
};
