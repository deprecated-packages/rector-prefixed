<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\Rector\DowngradePhp71\Rector\Array_\SymmetricArrayDestructuringToListRector;
use _PhpScoperb75b35f52b74\Rector\DowngradePhp71\Rector\ClassConst\DowngradeClassConstantVisibilityRector;
use _PhpScoperb75b35f52b74\Rector\DowngradePhp71\Rector\FunctionLike\DowngradeNullableTypeParamDeclarationRector;
use _PhpScoperb75b35f52b74\Rector\DowngradePhp71\Rector\FunctionLike\DowngradeNullableTypeReturnDeclarationRector;
use _PhpScoperb75b35f52b74\Rector\DowngradePhp71\Rector\FunctionLike\DowngradeVoidTypeReturnDeclarationRector;
use _PhpScoperb75b35f52b74\Rector\DowngradePhp71\Rector\String_\DowngradeNegativeStringOffsetToStrlenRector;
use _PhpScoperb75b35f52b74\Rector\DowngradePhp71\Rector\TryCatch\DowngradePipeToMultiCatchExceptionRector;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoperb75b35f52b74\Rector\DowngradePhp71\Rector\FunctionLike\DowngradeNullableTypeParamDeclarationRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\DowngradePhp71\Rector\FunctionLike\DowngradeNullableTypeReturnDeclarationRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\DowngradePhp71\Rector\FunctionLike\DowngradeVoidTypeReturnDeclarationRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\DowngradePhp71\Rector\ClassConst\DowngradeClassConstantVisibilityRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\DowngradePhp71\Rector\TryCatch\DowngradePipeToMultiCatchExceptionRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\DowngradePhp71\Rector\Array_\SymmetricArrayDestructuringToListRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\DowngradePhp71\Rector\String_\DowngradeNegativeStringOffsetToStrlenRector::class);
};
