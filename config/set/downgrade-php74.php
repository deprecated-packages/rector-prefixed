<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa;

use _PhpScoper0a2ac50786fa\Rector\DowngradePhp74\Rector\Array_\DowngradeArraySpreadRector;
use _PhpScoper0a2ac50786fa\Rector\DowngradePhp74\Rector\ArrowFunction\ArrowFunctionToAnonymousFunctionRector;
use _PhpScoper0a2ac50786fa\Rector\DowngradePhp74\Rector\ClassMethod\DowngradeContravariantArgumentTypeRector;
use _PhpScoper0a2ac50786fa\Rector\DowngradePhp74\Rector\ClassMethod\DowngradeCovariantReturnTypeRector;
use _PhpScoper0a2ac50786fa\Rector\DowngradePhp74\Rector\Coalesce\DowngradeNullCoalescingOperatorRector;
use _PhpScoper0a2ac50786fa\Rector\DowngradePhp74\Rector\FuncCall\DowngradeArrayMergeCallWithoutArgumentsRector;
use _PhpScoper0a2ac50786fa\Rector\DowngradePhp74\Rector\FuncCall\DowngradeStripTagsCallWithArrayRector;
use _PhpScoper0a2ac50786fa\Rector\DowngradePhp74\Rector\Identical\DowngradeFreadFwriteFalsyToNegationRector;
use _PhpScoper0a2ac50786fa\Rector\DowngradePhp74\Rector\LNumber\DowngradeNumericLiteralSeparatorRector;
use _PhpScoper0a2ac50786fa\Rector\DowngradePhp74\Rector\Property\DowngradeTypedPropertyRector;
use _PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper0a2ac50786fa\Rector\DowngradePhp74\Rector\Property\DowngradeTypedPropertyRector::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\DowngradePhp74\Rector\ArrowFunction\ArrowFunctionToAnonymousFunctionRector::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\DowngradePhp74\Rector\ClassMethod\DowngradeCovariantReturnTypeRector::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\DowngradePhp74\Rector\ClassMethod\DowngradeContravariantArgumentTypeRector::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\DowngradePhp74\Rector\Coalesce\DowngradeNullCoalescingOperatorRector::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\DowngradePhp74\Rector\LNumber\DowngradeNumericLiteralSeparatorRector::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\DowngradePhp74\Rector\FuncCall\DowngradeStripTagsCallWithArrayRector::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\DowngradePhp74\Rector\Array_\DowngradeArraySpreadRector::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\DowngradePhp74\Rector\FuncCall\DowngradeArrayMergeCallWithoutArgumentsRector::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\DowngradePhp74\Rector\Identical\DowngradeFreadFwriteFalsyToNegationRector::class);
};
