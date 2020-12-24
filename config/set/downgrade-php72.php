<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\DowngradePhp72\Rector\ClassMethod\DowngradeParameterTypeWideningRector;
use _PhpScopere8e811afab72\Rector\DowngradePhp72\Rector\FunctionLike\DowngradeParamObjectTypeDeclarationRector;
use _PhpScopere8e811afab72\Rector\DowngradePhp72\Rector\FunctionLike\DowngradeReturnObjectTypeDeclarationRector;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScopere8e811afab72\Rector\DowngradePhp72\Rector\FunctionLike\DowngradeParamObjectTypeDeclarationRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\DowngradePhp72\Rector\FunctionLike\DowngradeReturnObjectTypeDeclarationRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\DowngradePhp72\Rector\ClassMethod\DowngradeParameterTypeWideningRector::class);
};
