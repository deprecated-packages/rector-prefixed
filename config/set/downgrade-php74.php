<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\Rector\DowngradePhp74\Rector\Array_\DowngradeArraySpreadRector;
use _PhpScoperb75b35f52b74\Rector\DowngradePhp74\Rector\ArrowFunction\ArrowFunctionToAnonymousFunctionRector;
use _PhpScoperb75b35f52b74\Rector\DowngradePhp74\Rector\ClassMethod\DowngradeContravariantArgumentTypeRector;
use _PhpScoperb75b35f52b74\Rector\DowngradePhp74\Rector\ClassMethod\DowngradeCovariantReturnTypeRector;
use _PhpScoperb75b35f52b74\Rector\DowngradePhp74\Rector\Coalesce\DowngradeNullCoalescingOperatorRector;
use _PhpScoperb75b35f52b74\Rector\DowngradePhp74\Rector\FuncCall\DowngradeArrayMergeCallWithoutArgumentsRector;
use _PhpScoperb75b35f52b74\Rector\DowngradePhp74\Rector\FuncCall\DowngradeStripTagsCallWithArrayRector;
use _PhpScoperb75b35f52b74\Rector\DowngradePhp74\Rector\Identical\DowngradeFreadFwriteFalsyToNegationRector;
use _PhpScoperb75b35f52b74\Rector\DowngradePhp74\Rector\LNumber\DowngradeNumericLiteralSeparatorRector;
use _PhpScoperb75b35f52b74\Rector\DowngradePhp74\Rector\Property\DowngradeTypedPropertyRector;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoperb75b35f52b74\Rector\DowngradePhp74\Rector\Property\DowngradeTypedPropertyRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\DowngradePhp74\Rector\ArrowFunction\ArrowFunctionToAnonymousFunctionRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\DowngradePhp74\Rector\ClassMethod\DowngradeCovariantReturnTypeRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\DowngradePhp74\Rector\ClassMethod\DowngradeContravariantArgumentTypeRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\DowngradePhp74\Rector\Coalesce\DowngradeNullCoalescingOperatorRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\DowngradePhp74\Rector\LNumber\DowngradeNumericLiteralSeparatorRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\DowngradePhp74\Rector\FuncCall\DowngradeStripTagsCallWithArrayRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\DowngradePhp74\Rector\Array_\DowngradeArraySpreadRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\DowngradePhp74\Rector\FuncCall\DowngradeArrayMergeCallWithoutArgumentsRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\DowngradePhp74\Rector\Identical\DowngradeFreadFwriteFalsyToNegationRector::class);
};
