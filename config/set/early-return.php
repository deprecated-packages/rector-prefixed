<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\EarlyReturn\Rector\Foreach_\ChangeNestedForeachIfsToEarlyContinueRector;
use _PhpScopere8e811afab72\Rector\EarlyReturn\Rector\If_\ChangeAndIfToEarlyReturnRector;
use _PhpScopere8e811afab72\Rector\EarlyReturn\Rector\If_\ChangeIfElseValueAssignToEarlyReturnRector;
use _PhpScopere8e811afab72\Rector\EarlyReturn\Rector\If_\ChangeNestedIfsToEarlyReturnRector;
use _PhpScopere8e811afab72\Rector\EarlyReturn\Rector\If_\RemoveAlwaysElseRector;
use _PhpScopere8e811afab72\Rector\EarlyReturn\Rector\Return_\ReturnBinaryAndToEarlyReturnRector;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScopere8e811afab72\Rector\EarlyReturn\Rector\Foreach_\ChangeNestedForeachIfsToEarlyContinueRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\EarlyReturn\Rector\If_\ChangeAndIfToEarlyReturnRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\EarlyReturn\Rector\If_\ChangeIfElseValueAssignToEarlyReturnRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\EarlyReturn\Rector\If_\ChangeNestedIfsToEarlyReturnRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\EarlyReturn\Rector\If_\RemoveAlwaysElseRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\EarlyReturn\Rector\Return_\ReturnBinaryAndToEarlyReturnRector::class);
};
