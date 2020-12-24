<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\DowngradePhp74\Rector\Array_\DowngradeArraySpreadRector;
use _PhpScopere8e811afab72\Rector\DowngradePhp74\Rector\ArrowFunction\ArrowFunctionToAnonymousFunctionRector;
use _PhpScopere8e811afab72\Rector\DowngradePhp74\Rector\ClassMethod\DowngradeContravariantArgumentTypeRector;
use _PhpScopere8e811afab72\Rector\DowngradePhp74\Rector\ClassMethod\DowngradeCovariantReturnTypeRector;
use _PhpScopere8e811afab72\Rector\DowngradePhp74\Rector\Coalesce\DowngradeNullCoalescingOperatorRector;
use _PhpScopere8e811afab72\Rector\DowngradePhp74\Rector\FuncCall\DowngradeArrayMergeCallWithoutArgumentsRector;
use _PhpScopere8e811afab72\Rector\DowngradePhp74\Rector\FuncCall\DowngradeStripTagsCallWithArrayRector;
use _PhpScopere8e811afab72\Rector\DowngradePhp74\Rector\Identical\DowngradeFreadFwriteFalsyToNegationRector;
use _PhpScopere8e811afab72\Rector\DowngradePhp74\Rector\LNumber\DowngradeNumericLiteralSeparatorRector;
use _PhpScopere8e811afab72\Rector\DowngradePhp74\Rector\Property\DowngradeTypedPropertyRector;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScopere8e811afab72\Rector\DowngradePhp74\Rector\Property\DowngradeTypedPropertyRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\DowngradePhp74\Rector\ArrowFunction\ArrowFunctionToAnonymousFunctionRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\DowngradePhp74\Rector\ClassMethod\DowngradeCovariantReturnTypeRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\DowngradePhp74\Rector\ClassMethod\DowngradeContravariantArgumentTypeRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\DowngradePhp74\Rector\Coalesce\DowngradeNullCoalescingOperatorRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\DowngradePhp74\Rector\LNumber\DowngradeNumericLiteralSeparatorRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\DowngradePhp74\Rector\FuncCall\DowngradeStripTagsCallWithArrayRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\DowngradePhp74\Rector\Array_\DowngradeArraySpreadRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\DowngradePhp74\Rector\FuncCall\DowngradeArrayMergeCallWithoutArgumentsRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\DowngradePhp74\Rector\Identical\DowngradeFreadFwriteFalsyToNegationRector::class);
};
