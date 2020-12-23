<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa;

use _PhpScoper0a2ac50786fa\Rector\DowngradePhp71\Rector\Array_\SymmetricArrayDestructuringToListRector;
use _PhpScoper0a2ac50786fa\Rector\DowngradePhp71\Rector\ClassConst\DowngradeClassConstantVisibilityRector;
use _PhpScoper0a2ac50786fa\Rector\DowngradePhp71\Rector\FunctionLike\DowngradeNullableTypeParamDeclarationRector;
use _PhpScoper0a2ac50786fa\Rector\DowngradePhp71\Rector\FunctionLike\DowngradeNullableTypeReturnDeclarationRector;
use _PhpScoper0a2ac50786fa\Rector\DowngradePhp71\Rector\FunctionLike\DowngradeVoidTypeReturnDeclarationRector;
use _PhpScoper0a2ac50786fa\Rector\DowngradePhp71\Rector\String_\DowngradeNegativeStringOffsetToStrlenRector;
use _PhpScoper0a2ac50786fa\Rector\DowngradePhp71\Rector\TryCatch\DowngradePipeToMultiCatchExceptionRector;
use _PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper0a2ac50786fa\Rector\DowngradePhp71\Rector\FunctionLike\DowngradeNullableTypeParamDeclarationRector::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\DowngradePhp71\Rector\FunctionLike\DowngradeNullableTypeReturnDeclarationRector::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\DowngradePhp71\Rector\FunctionLike\DowngradeVoidTypeReturnDeclarationRector::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\DowngradePhp71\Rector\ClassConst\DowngradeClassConstantVisibilityRector::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\DowngradePhp71\Rector\TryCatch\DowngradePipeToMultiCatchExceptionRector::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\DowngradePhp71\Rector\Array_\SymmetricArrayDestructuringToListRector::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\DowngradePhp71\Rector\String_\DowngradeNegativeStringOffsetToStrlenRector::class);
};
