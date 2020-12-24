<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\Php54\Rector\Break_\RemoveZeroBreakContinueRector;
use _PhpScopere8e811afab72\Rector\Php54\Rector\FuncCall\RemoveReferenceFromCallRector;
use _PhpScopere8e811afab72\Rector\Renaming\Rector\FuncCall\RenameFunctionRector;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScopere8e811afab72\Rector\Renaming\Rector\FuncCall\RenameFunctionRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Renaming\Rector\FuncCall\RenameFunctionRector::OLD_FUNCTION_TO_NEW_FUNCTION => ['mysqli_param_count' => 'mysqli_stmt_param_count']]]);
    $services->set(\_PhpScopere8e811afab72\Rector\Php54\Rector\FuncCall\RemoveReferenceFromCallRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Php54\Rector\Break_\RemoveZeroBreakContinueRector::class);
};
