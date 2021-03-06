<?php

declare (strict_types=1);
namespace RectorPrefix20210306;

return static function (\RectorPrefix20210306\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\TypeDeclaration\Rector\FunctionLike\ParamTypeDeclarationRector::class);
    $services->set(\Rector\TypeDeclaration\Rector\FunctionLike\ReturnTypeDeclarationRector::class);
    $services->set(\Rector\TypeDeclaration\Rector\Property\PropertyTypeDeclarationRector::class);
    $services->set(\Rector\TypeDeclaration\Rector\Closure\AddClosureReturnTypeRector::class);
    $services->set(\Rector\TypeDeclaration\Rector\ClassMethod\AddArrayParamDocTypeRector::class);
    $services->set(\Rector\TypeDeclaration\Rector\ClassMethod\AddArrayReturnDocTypeRector::class);
    // $services->set(\Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeFromCallersRector::class);
};
