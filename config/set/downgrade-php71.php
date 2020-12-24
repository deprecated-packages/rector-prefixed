<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\DowngradePhp71\Rector\Array_\SymmetricArrayDestructuringToListRector;
use _PhpScopere8e811afab72\Rector\DowngradePhp71\Rector\ClassConst\DowngradeClassConstantVisibilityRector;
use _PhpScopere8e811afab72\Rector\DowngradePhp71\Rector\FunctionLike\DowngradeNullableTypeParamDeclarationRector;
use _PhpScopere8e811afab72\Rector\DowngradePhp71\Rector\FunctionLike\DowngradeNullableTypeReturnDeclarationRector;
use _PhpScopere8e811afab72\Rector\DowngradePhp71\Rector\FunctionLike\DowngradeVoidTypeReturnDeclarationRector;
use _PhpScopere8e811afab72\Rector\DowngradePhp71\Rector\String_\DowngradeNegativeStringOffsetToStrlenRector;
use _PhpScopere8e811afab72\Rector\DowngradePhp71\Rector\TryCatch\DowngradePipeToMultiCatchExceptionRector;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScopere8e811afab72\Rector\DowngradePhp71\Rector\FunctionLike\DowngradeNullableTypeParamDeclarationRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\DowngradePhp71\Rector\FunctionLike\DowngradeNullableTypeReturnDeclarationRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\DowngradePhp71\Rector\FunctionLike\DowngradeVoidTypeReturnDeclarationRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\DowngradePhp71\Rector\ClassConst\DowngradeClassConstantVisibilityRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\DowngradePhp71\Rector\TryCatch\DowngradePipeToMultiCatchExceptionRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\DowngradePhp71\Rector\Array_\SymmetricArrayDestructuringToListRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\DowngradePhp71\Rector\String_\DowngradeNegativeStringOffsetToStrlenRector::class);
};
