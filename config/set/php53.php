<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\Php53\Rector\AssignRef\ClearReturnNewByReferenceRector;
use _PhpScopere8e811afab72\Rector\Php53\Rector\FuncCall\DirNameFileConstantToDirConstantRector;
use _PhpScopere8e811afab72\Rector\Php53\Rector\Ternary\TernaryToElvisRector;
use _PhpScopere8e811afab72\Rector\Php53\Rector\Variable\ReplaceHttpServerVarsByServerRector;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScopere8e811afab72\Rector\Php53\Rector\Ternary\TernaryToElvisRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Php53\Rector\FuncCall\DirNameFileConstantToDirConstantRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Php53\Rector\AssignRef\ClearReturnNewByReferenceRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Php53\Rector\Variable\ReplaceHttpServerVarsByServerRector::class);
};
