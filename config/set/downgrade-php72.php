<?php

declare (strict_types=1);
namespace _PhpScoperbf340cb0be9d;

use Rector\DowngradePhp72\Rector\ClassMethod\DowngradeParameterTypeWideningRector;
use Rector\DowngradePhp72\Rector\FunctionLike\DowngradeParamObjectTypeDeclarationRector;
use Rector\DowngradePhp72\Rector\FunctionLike\DowngradeReturnObjectTypeDeclarationRector;
use _PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\DowngradePhp72\Rector\FunctionLike\DowngradeParamObjectTypeDeclarationRector::class);
    $services->set(\Rector\DowngradePhp72\Rector\FunctionLike\DowngradeReturnObjectTypeDeclarationRector::class);
    $services->set(\Rector\DowngradePhp72\Rector\ClassMethod\DowngradeParameterTypeWideningRector::class);
};
