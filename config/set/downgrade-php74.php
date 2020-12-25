<?php

declare (strict_types=1);
namespace _PhpScoper50d83356d739;

use Rector\DowngradePhp74\Rector\Array_\DowngradeArraySpreadRector;
use Rector\DowngradePhp74\Rector\ArrowFunction\ArrowFunctionToAnonymousFunctionRector;
use Rector\DowngradePhp74\Rector\ClassMethod\DowngradeContravariantArgumentTypeRector;
use Rector\DowngradePhp74\Rector\ClassMethod\DowngradeCovariantReturnTypeRector;
use Rector\DowngradePhp74\Rector\Coalesce\DowngradeNullCoalescingOperatorRector;
use Rector\DowngradePhp74\Rector\FuncCall\DowngradeArrayMergeCallWithoutArgumentsRector;
use Rector\DowngradePhp74\Rector\FuncCall\DowngradeStripTagsCallWithArrayRector;
use Rector\DowngradePhp74\Rector\Identical\DowngradeFreadFwriteFalsyToNegationRector;
use Rector\DowngradePhp74\Rector\LNumber\DowngradeNumericLiteralSeparatorRector;
use Rector\DowngradePhp74\Rector\Property\DowngradeTypedPropertyRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\DowngradePhp74\Rector\Property\DowngradeTypedPropertyRector::class);
    $services->set(\Rector\DowngradePhp74\Rector\ArrowFunction\ArrowFunctionToAnonymousFunctionRector::class);
    $services->set(\Rector\DowngradePhp74\Rector\ClassMethod\DowngradeCovariantReturnTypeRector::class);
    $services->set(\Rector\DowngradePhp74\Rector\ClassMethod\DowngradeContravariantArgumentTypeRector::class);
    $services->set(\Rector\DowngradePhp74\Rector\Coalesce\DowngradeNullCoalescingOperatorRector::class);
    $services->set(\Rector\DowngradePhp74\Rector\LNumber\DowngradeNumericLiteralSeparatorRector::class);
    $services->set(\Rector\DowngradePhp74\Rector\FuncCall\DowngradeStripTagsCallWithArrayRector::class);
    $services->set(\Rector\DowngradePhp74\Rector\Array_\DowngradeArraySpreadRector::class);
    $services->set(\Rector\DowngradePhp74\Rector\FuncCall\DowngradeArrayMergeCallWithoutArgumentsRector::class);
    $services->set(\Rector\DowngradePhp74\Rector\Identical\DowngradeFreadFwriteFalsyToNegationRector::class);
};
