<?php

declare (strict_types=1);
namespace RectorPrefix20210123;

use Rector\DowngradePhp71\Rector\Array_\SymmetricArrayDestructuringToListRector;
use Rector\DowngradePhp71\Rector\ClassConst\DowngradeClassConstantVisibilityRector;
use Rector\DowngradePhp71\Rector\FunctionLike\DowngradeNullableTypeParamDeclarationRector;
use Rector\DowngradePhp71\Rector\FunctionLike\DowngradeNullableTypeReturnDeclarationRector;
use Rector\DowngradePhp71\Rector\FunctionLike\DowngradeVoidTypeReturnDeclarationRector;
use Rector\DowngradePhp71\Rector\String_\DowngradeNegativeStringOffsetToStrlenRector;
use Rector\DowngradePhp71\Rector\TryCatch\DowngradePipeToMultiCatchExceptionRector;
use RectorPrefix20210123\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210123\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\DowngradePhp71\Rector\FunctionLike\DowngradeNullableTypeParamDeclarationRector::class);
    $services->set(\Rector\DowngradePhp71\Rector\FunctionLike\DowngradeNullableTypeReturnDeclarationRector::class);
    $services->set(\Rector\DowngradePhp71\Rector\FunctionLike\DowngradeVoidTypeReturnDeclarationRector::class);
    $services->set(\Rector\DowngradePhp71\Rector\ClassConst\DowngradeClassConstantVisibilityRector::class);
    $services->set(\Rector\DowngradePhp71\Rector\TryCatch\DowngradePipeToMultiCatchExceptionRector::class);
    $services->set(\Rector\DowngradePhp71\Rector\Array_\SymmetricArrayDestructuringToListRector::class);
    $services->set(\Rector\DowngradePhp71\Rector\String_\DowngradeNegativeStringOffsetToStrlenRector::class);
};
